<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAssign;
use App\Models\StudentExam;
use App\Models\StudentExamDetails;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $model;

    public function __construct(Exam $model){
        $this->model = $model;

    }

    public function index()
    {
        // $this->checkExamAvailable();
        return view('website.student.exams.index',[
        ]);
    }

    public function startExam($id)
    {
        $title = __('lang.send_exam_answerd');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);
        $exam = $this->model->find($id);
        $studentExam = StudentExam::firstOrCreate([
            'user_id' => auth()->user()->id,
            'exam_id' => $id,
            'grade' => $exam->grade,
            'is_started' => 1,
        ]);
        $studentExam->start_date = $studentExam->created_at;
        $studentExam->save();

        $userExam= StudentExam::where('user_id',auth()->user()->id)->where('exam_id',$id)->first();
        if (($userExam->current_time == $exam->minutes) || ($userExam->is_finished == 1)) {
            alert()->error('','Exam Finished');
            return back();
        }

        return view('website.student.exams.start',[
            'exam' => $exam,
            'userExam' => $userExam,
        ]);

    }


    public function saveAnswer(Request $request)
    {
        // dd('ds');
        $exam = Exam::find($request->exam_id);
        $userExam = StudentExam::where('user_id',auth()->user()->id)
            ->where('exam_id',$request->exam_id)->first();
        foreach ($exam->questions as $question) {
            $data = [
                'student_exam_id' => $userExam->id,
                'question_id' => $question->id,
            ];
            if (isset($request->answer[$question->id])) {
                $data['answer_id'] = $request->answer[$question->id];
            }
            StudentExamDetails::create($data);
        }
        $questionCorrectCount = $userExam->studentExamDetails->where('is_correct',1)->count() ?? 0;
        $questionNotCorrectCount = $userExam->studentExamDetails->where('is_correct','!=',1)->count() ?? 0;
        $degree = ($exam->grade / $exam->question_number) * $questionCorrectCount ;
        $userExam->update([
            // 'current_time' => $exam->minutes,
            'end_date' => date('Y-m-d H:i:s'),
            'is_finished' => 1,
            'student_grade' => $degree,
        ]);
         alert()->success('','Exam Finished');
        return redirect()->route('front.exam.index');
    }


    public function setExamPass($id)
    {
        return view('website.student.exams.includes.modal-of-set-exam-password',[
            'exam' => $this->model->find($id),
        ]);
    }



    public function checkExamPass(Request $request)
    {
        $exam = $this->model->find($request->exam_id);
        if ($request->password != $exam->password) {
          alert()->error(__('lang.wrong_password') );
           return back();
        }
       return redirect()->route('front.exam.start',['id' => $request->exam_id]);
    }


    public function updateExamTime(Request $request)
    {
        // dd((int)$request->current_time);
        $exam = Exam::find($request->exam_id);
        $userExam = StudentExam::firstOrCreate([
            'user_id' => auth()->user()->id,
            'exam_id' => $request->exam_id,
        ]);

        $total = $userExam->current_time + (int)$request->current_time;
        $userExam->current_time = $total;
        // dd($userExam->current_time);
        if ($userExam->current_time == $exam->minutes) {
            $userExam->end_date = date('Y-m-d H:i:s');
            $userExam->is_finished = 1;
        }
        $userExam->save();

        return response()->json([
            'success' => true,
            'message' => 'Exam Updated',
        ]);
    }



    public function showExamGrade($id)
    {
        $exam = Exam::find($id);

        $studentExam = StudentExam::with('studentExamDetails')->where('user_id',auth()->user()->id)->where('exam_id',$id)->first();
        if(!$studentExam){
            $userExam = StudentExam::firstOrCreate([
                'user_id' => auth()->user()->id,
                'exam_id' => $id,
                'grade' => $exam->grade,
                'is_started' => 1,
                'is_finished' => 1,
            ]);
            foreach ($exam->questions as $question) {
                $data = [
                    'student_exam_id' => $userExam->id,
                    'question_id' => $question->id,
                ];
                StudentExamDetails::create($data);
            }
            $userExam->start_date = $userExam->created_at;
            $userExam->end_date = date('Y-m-d H:i:s');
            $userExam->save();
        }
        // dd($studentExam);
        $questionCorrectCount = $studentExam->studentExamDetails->where('is_correct',1)->count() ?? 0;
        $questionNotCorrectCount = $studentExam->studentExamDetails->where('is_correct','!=',1)->count() ?? 0;
        $degree = ($exam->grade / $exam->question_number) * $questionCorrectCount ;
        return view('website.student.exams.exam-grade',[
            'exam' => $exam,
            'studentExam' => $studentExam,
            'questionCorrectCount' => $questionCorrectCount,
            'questionNotCorrectCount' => $questionNotCorrectCount,
            'degree' => $degree,
        ]);

    }


/**
 * Checks if the exam is available for the user.
 *
 * @throws Some_Exception_Class description of exception
 * @return Some_Return_Value
 */
private function checkExamAvailable()
{
    $user = auth()->user();
    $today = date('Y-m-d');

    foreach ($user->activeExams() as $exam) {
        $studentExam = StudentExam::with('studentExamDetails')
            ->where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        if (!$studentExam && $today > $exam->start_date) {
            $userExam = StudentExam::firstOrCreate([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'grade' => $exam->grade,
                'is_started' => 1,
                'is_finished' => 1,
            ]);

            $questionIds = $exam->questions->pluck('id')->toArray();
            $studentExamDetails = array_map(function ($questionId) use ($userExam) {
                return [
                    'student_exam_id' => $userExam->id,
                    'question_id' => $questionId,
                ];
            }, $questionIds);

            StudentExamDetails::insert($studentExamDetails);

            $questionCorrectCount = $userExam->studentExamDetails->where('is_correct', 1)->count() ?? 0;
            $degree = ($exam->grade / $exam->question_number) * $questionCorrectCount;

            $userExam->start_date = $userExam->created_at;
            $userExam->student_grade = $degree;
            $userExam->end_date = date('Y-m-d H:i:s');
            $userExam->save();
        }
    }
}
}
