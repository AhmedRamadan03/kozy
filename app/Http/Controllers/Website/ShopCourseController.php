<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\AccademicYear;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;

class ShopCourseController extends Controller
{

    protected $model ;

    public function __construct(Course $model){
        $this->model = $model;
    }



    public function index(Request $request)
    {
        $models = $this->model->where(function($q) use ($request){
            $this->model->scopeWebsiteFilter($q , $request);
        })->where('is_active', 1)->inRandomOrder();
        return view('website.shop-courses.index', [
            'courses' => $models->paginate(20),
            'levels' => Level::get()->pluck('title', 'id'),
            'years' => AccademicYear::forDroupDown(true,true)
        ]);
    }
}
