<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Offer;
use App\Models\Partener;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

            $query = Product::active()->where('country_id',session('country')->id)->latest();

        return view('website::home.index',[
            'sliders' => Slider::active()->where('country_id',session('country')->id)->get(),
            'features' => Feature::get(),
            'categories' => Category::active()->parent()->where('country_id',session('country')->id)->take(5)->get(),
            'products' => $query->get()->take(8),
            'offers' => Offer::where('start_date','<=',now()->format('Y-m-d'))->where('end_date','>=',now()->format('Y-m-d'))->take(4)->get(),
        ]);
    }



    public function updateSession()
    {
        $country = Country::findOrFail(request()->country_id);
        session()->put('country',$country);
        return back();
    }
   public function returnRules()
   {
    return view('website::home.return-rules',[
    ]);
   }


   public function aboutUs()
   {
    return view('website::about-us.index',[
        'about' => About::first(),
        'features' => Feature::get(),
        // 'faqs' => Faq::get()
    ]);
   }


   public function contactUs()
   {
    return view('website::contact-us.index');
   }
}
