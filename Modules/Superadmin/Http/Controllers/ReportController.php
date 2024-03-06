<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Exports\StudentExamExport;
use App\Models\Exam;
use App\Models\Group;
use App\Models\Level;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function examReport()
    {
        $query = StudentExam::where('is_finished', 1);
        // $query->orderBy('student_grade', 'ASC');
        // dd($query->paginate(20));
        if (request()->exam_id) {
            $query->where('exam_id', request()->exam_id);
        }

        if (request()->group_id) {
            $query->whereHas('user', function ($q) {
                $q->where('group_id', request()->group_id);
                return $q;
            });
        }
        if (request()->level_id) {

            $query->whereHas('user', function ($q) {
                $q->where('level_id', request()->level_id);
                return $q;
            });
        }

        if (request()->search) {
            $query->whereHas('user', function ($q) {
                $q->where('first_name', 'LIKE', '%' . request()->search . '%');
                $q->orWhere('phone', 'LIKE', '%' . request()->search . '%');
                return $q;
            });
        }

        if (request()->sort) {
            $query->orderBy('student_grade', request()->sort);
        }

        $examReports = $query->paginate(20);
        return view('superadmin::reports.exam-report',[
            'examReports' => $examReports,
            'groups' => Group::get()->pluck('title', 'id')->toArray(),
            'levels' => Level::get()->pluck('title', 'id')->toArray(),
            'exams' =>Exam::get()->pluck('title', 'id')->toArray(),
        ]);
    }


    public function export()
    {
        $filiters = request()->except('_token');
        return Excel::download(new StudentExamExport($filiters), 'تقرير_امتحان.xlsx');
    }
}
