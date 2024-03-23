<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Size;
use App\Models\Slider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $query = Product::active()->where('country_id',session('country')->id)->filter();
        return view('website::categories.index',[
            'categories' => Category::where('country_id',session('country')->id)->active()->whereHas('children')->get(),
            'products' => $query->paginate(20),
            'brands'=> Brand::active()->where('country_id',session('country')->id)->get(),
            // 'offers' => Offer::where('start_date','<=',now()->format('Y-m-d'))->where('end_date','>=',now()->format('Y-m-d'))->take(4)->get(),
        ]);
    }


    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->where('country_id',session('country')->id)->first();
        if(!$product){

            return redirect()->route('front.categories');
        }
        $sameProducts = Product::active()->where('country_id',session('country')->id)->where('category_id',$product->category_id)->take(4)->get();
        return view('website::categories.productDetails',compact('product','sameProducts'));
    }


    public function getProductsSizes(Request $request){
        $productSizes = ProductVariation::where('product_id' , $request->product_id )->where('color_id',$request->color_id)->get();
        return view('website::categories.product-size' , compact('productSizes'));
    }


}
