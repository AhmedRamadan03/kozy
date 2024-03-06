<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Cart\StoreCartRequest;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected $model ;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }


    /**
    * Display a listing of the resource.
    * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
   public function index()
   {
       $carts = $this->responseData();
       return view('website.cart.index', compact('carts'));
   }
    public function store(StoreCartRequest $request)
    {
        // Get Inputs From Request
        $inputs = $request->validated()['cart'];
        // course Data
        $course = Course::where('code', $inputs['course_code'])->first();
        // Store Data To Cart
        if(auth()->check()){
            $data=['user_id'=> auth()->user()->id , 'course_id'=> $course->id, 'price' => $course->price];
            $this->storeDB($data, $course);
            $resultCheckout = $this->responseData();
            $res = [
                'resultCheckout' => view('website.include.cart-down', compact('resultCheckout'))->render(),
                'items_count' => $resultCheckout['items_count']
            ];
            return responseJson(true, __('lang.products_added_to_cart'), $res);
        }
    }


    private function responseData()
    {
        $carts = auth()->check() ? $this->model->where('user_id', auth()->user()->id)->with('course')->get() : Cart::content();
        $data = [
            'items' => $carts,
            'items_count' => $carts->count(),
            'sub_total' => $carts->sum('price'),

        ];
        return $data;
    }



    private function storeDB($data ,$course)
    {
        $carts = $this->model->where('user_id', auth()->user()->id)->get();
        $course = Course::where('code', $course->code)->first();

        if(count($carts)) {
            // Get data from cart
            $cart = $carts->where('course_id', $course->id);
            $item = $cart->where('course_id', $course->id)->first();

            // Check if existing data
            if(!$item) {
                Cart::create($data);
            }
        } else {
            // Add items to cart
            Cart::create($data);
        }
        return true;
    }



    public function remove(Request $request)
    {
        // course Data
        if(auth()->check()){
        $item = Cart::where('id', $request->id)->where('user_id', auth()->user()->id)->delete();

        // Store Data To Cart
            $resultCheckout = $this->responseData();
            // dd($resultCheckout);
            $res = [
                'resultCheckout' => view('website.include.cart-down', compact('resultCheckout'))->render(),
                'items_count' => $resultCheckout['items_count']
            ];
            return responseJson(true, __('lang.course_remove_successflly'), $res);
        }
    }
}
