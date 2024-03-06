<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Course;
use App\Models\Feature;
use App\Models\Level;
use App\Models\Slider;
use App\Models\StudentBoard;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('website.home.index',[
            'sliders' => Slider::where('is_active',1)->get(),
            'features' => Feature::get(),
            'about' => About::first(),
            'courses' => Course::where('is_active',1)->latest()->take(6)->get(),
            'levels' => Level::get(),
            'topStudents' => StudentBoard::where('is_active',1)->latest()->get(),
        ]);
    }
}
