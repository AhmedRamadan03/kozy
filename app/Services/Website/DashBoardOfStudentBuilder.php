<?php

namespace App\Services\Website;

use App\Models\StudentExam;
use Illuminate\Support\Facades\DB;

class DashBoardOfStudentBuilder
{

    private $data;
    private $userId;
    private $activeCoursesCount;
    private $lectureCount;
    public function __construct()
    {
        $this->data =[];
        $this->getUserId();
        $this->getActiveCourses();
        $this->getLectureCount();
    }

    private function getUserId(){
        $this->userId = auth()->user()->id;

    }

    private function getActiveCourses(){
        $this->activeCoursesCount = auth()->user()->activeCourses()->count();
    }

    private function getLectureCount(){
        $courseIds = auth()->user()->activeCourses()->pluck('courses.id')->toArray();
        $this->lectureCount = DB::table('lectures')->whereIn('course_id' , $courseIds)->count();
    }

    private function getLectureCompleteCount()
    {
        $courseIds = auth()->user()->activeCourses()->pluck('courses.id')->toArray();
        $lectureIds = DB::table('lectures')->whereIn('course_id' , $courseIds)->pluck('id')->toArray();
        return DB::table('student_video_views')->whereIn('lecture_id' , $lectureIds)->count();
    }

    private function getLectureNotCompleteCount(){
        $courseIds = auth()->user()->activeCourses()->pluck('courses.id')->toArray();
        $lectureIds = DB::table('lectures')->whereIn('course_id' , $courseIds)->pluck('id')->toArray();
        return DB::table('student_video_views')->whereNotIn('lecture_id' , $lectureIds)->count();
    }

    private function getExamCompleteCount(){
        $examIds = auth()->user()->activeExams()->pluck('id')->toArray();
        // dd($examIds);
        return DB::table('student_exams')->whereIn('exam_id' , $examIds)->where('user_id' , $this->userId)->where('student_grade', '>' , 0)->where('is_finished' , 1)->count();
    }

    private function getExamNotCompleteCount(){
        $examIds = auth()->user()->activeExams()->pluck('id')->toArray();
        // dd($examIds);
        return DB::table('student_exams')->where('user_id' , $this->userId)->whereIn('exam_id' , $examIds)->where('student_grade' , 0)->where('is_finished' , 1)->count();
    }

    public function getTotals()
    {
        $totals = [
            [
                'label' => __('lang.courses'),
                'img' => '<i class="ti ti-book fs-1"></i>',
                'color' => 'info',
                'count' => $this->activeCoursesCount
            ],
            [
                'label' => __('lang.lectures'),
                'img' => '<i class="ti ti-file-description fs-1"></i>',
                'color' => 'info',
                'count' => $this->lectureCount
            ],
            [
                'label' => __('lang.lectures_complete'),
                'img' => '<i class="ti ti-brand-zoom fs-1"></i>',
                'color' => 'success',
                'count' => $this->getLectureCompleteCount()
            ],
            [
                'label' => __('lang.lectures_not_complete'),
                'img' => '<i class="ti ti-brand-zoom fs-1"></i>',
                'color' => 'danger',
                'count' => $this->getLectureNotCompleteCount()
            ],
            [
                'label' => __('lang.exams_complete'),
                'img' => '<i class="ti ti-file-pencil fs-1"></i>',
                'color' => 'success',
                'count' => $this->getExamCompleteCount()
            ],
            [
                'label' => __('lang.exams_not_complete'),
                'img' => '<i class="ti ti-file-pencil fs-1"></i>',
                'color' => 'danger',
                'count' => $this->getExamNotCompleteCount()
            ],

        ];

        $this->data['totals'] = $totals;
        return $this;
    }





    public function build()
    {
        return $this->data;
    }

}
