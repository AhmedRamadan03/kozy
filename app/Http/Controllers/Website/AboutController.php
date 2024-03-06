<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Feature;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {

        return view('website.about.index',[
            'about' => About::first(),
            'features' => Feature::get(),
        ]);
    }
}
