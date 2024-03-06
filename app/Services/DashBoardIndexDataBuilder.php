<?php

namespace App\Services;

use App\Models\StudentExam;
use Illuminate\Support\Facades\DB;

class DashBoardIndexDataBuilder
{

    private $data;
    public function __construct()
    {
        $this->data =[];
    }



    public function getTotals()
    {
        $totals = [
            // [
            //     'show' => auth()->user('admin')->isAbleTo('admin_read-students'),
            //     'label' => __('lang.students'),
            //     'href' => route('admin.student.index'),
            //     'img' => asset('icons/users.png'),
            //     'count' => DB::table('users')->count(),
            // ],


            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-admins'),
                'label' => __('lang.admins'),
                'href' => route('admin.admin.index'),
                'img' => asset('icons/admin.png'),
                'count' => DB::table('admins')->count(),
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
