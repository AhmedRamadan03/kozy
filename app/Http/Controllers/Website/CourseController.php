<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Folder;
use App\Models\Lecture;
use App\Models\StudentAssignment;
use App\Models\StudentVideoView;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(){
        return view('website.student.courses.index',[
            'data' => auth()->user()->activeCourses()->paginate(10),
        ]);
    }


    public function show($code)
    {
        $course = Course::with('activeLectures')->where('code', $code)->first();
        return view('website.student.courses.show',[
            'course' => $course
        ]);
    }


    public function getLecture($course_code,$lecture_code)
    {
        $course = Course::where('code', $course_code)->first();
        return view('website.student.courses.lectures.show',[
            'lecture' => Lecture::where('code', $lecture_code)->where('course_id', $course->id)->first(),
            'course' => Course::with('activeLectures')->where('code', $course_code)->first(),
        ]);
    }

    public function getAssinments($course_code)
    {
        $course = Course::where('code', $course_code)->first();

        return view('website.student.courses.assignments.index',[
            'assignments' => Assignment::where('course_id', $course->id)->get(),
            'course' => Course::where('code', $course_code)->first(),
        ]);
    }



    public function showAssignment($course_code ,$id)
    {
        $course = Course::where('code', $course_code)->first();
        return view('website.student.courses.assignments.show',[
            'assignment' => Assignment::where('id', $id)->where('course_id', $course->id)->first(),
        ]);
    }




    public function answerAssignment($course_code ,$id)
    {
        $course = Course::where('code', $course_code)->first();
        return view('website.student.courses.assignments.answer-modal',[
            'assignment' => Assignment::where('id', $id)->where('course_id', $course->id)->first(),
        ]);
    }

    public function StoreAnswerAssignment(Request $request)
    {
        $inputs = $request->validate([
            'file' => 'required',
        ]);
        $inputs['original_name'] = $inputs['file']->getClientOriginalName();
        $inputs['file'] = uploadImage($inputs['file'] , config('path.ASSIGNMENT_PATH').'answer/' .auth()->user()->id .'/');
        $inputs['assignment_id'] = $request->input('assignment_id');
        $inputs['user_id'] = auth()->user()->id;
        StudentAssignment::create($inputs);

        toast(__('lang.assignment_answered_successfully'), 'success');

        return redirect()->back();
    }


    public function getDegreeAssignments(){
        return view('website.student.courses.assignments.degrees.index',[
            'degrees' => StudentAssignment::where('user_id', auth()->user()->id)->get()
        ]);
    }



    public function updateVideoDuration(Request $request)
    {
        $lecture_id = Lecture::where('code',$request->input('lecture_code'))->first()->id;
        $watchedDuration = $request->input('watched_duration');
        $is_completed = $request->input('is_completed');

        // Find or create the video view record
        $videoView = StudentVideoView::firstOrCreate([
            'user_id' => auth()->user()->id,
            'lecture_id' => $lecture_id,
            'video_duration' => $request->input('video_duration')
        ]);

        // Update the watched_duration
        if ($videoView->is_completed == 0) {
            $videoView->watched_duration = $watchedDuration;
            $videoView->is_completed = $is_completed;
            $videoView->save();
        }

        return response()->json(['message' => 'Video duration updated.']);
    }



    public function makeLectureCompleted(Request $request)
    {
        $lecture_id = Lecture::where('code',$request->input('lecture_code'))->first()->id;
        $videoView = StudentVideoView::firstOrCreate([
            'user_id' => auth()->user()->id,
            'lecture_id' => $lecture_id,
        ]);

            $videoView->is_completed = $request->is_completed;
            $videoView->save();

            $msg = __('lang.lecture_completed_successfully');
            if ($videoView->is_completed == 0)
                $msg = __('lang.lecture_not_completed_successfully');

            return responseJson(true, $msg);
    }



    public function getFiles()
    {
        return view('website.student.courses.folders.index',[
            'files' => Folder::latest()->paginate(20)
        ]);
    }



}
