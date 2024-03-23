<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Website\App\Http\Requests\StoreCartRequest;

class CartController extends Controller
{

    protected $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);
        return view('website::cart.index',[
            'carts' => $this->responseData(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('website::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreCartRequest $request)
    {
        $inputs = $request->cart;

        $inputs['user_id'] = auth()->user()->id;
        $inputs['country_id'] = session('country')->id;
        // dd($inputs);
        $product = Product::find($inputs['product_id']);

        if (!$this->storeDB($inputs, $product)) {
            return responseJson(false, __('front.msg_error_quantity', ['product' => $product->title]), 400);
        }
        $resultCheckout = $this->responseData();

        $res = [
            // 'resultCheckout' => view($this->frontView('include.cart-down'), compact('resultCheckout'))->render(),
            'items_count' => $resultCheckout['items_count'],
        ];
        return responseJson(true, __('lang.products_added_to_cart'),$res);
    }



    public function destroy($id)
    {
        $cart = $this->model->find($id);
        $cart->delete();
        return redirect()->back();
    }

    private function storeDB($inputs, $product)
    {
        $carts = $this->model->where('user_id', auth()->user()->id)->get();
        // dd($carts);

        if (count($carts)) {
            // Get data from cart
            $cart = $carts->where('product_id', $inputs['product_id']);
            // Check Product Quantity in Stock
            $product = DB::table('products')
                ->where('id', $inputs['product_id'])
                ->first();
            // dd( $product_variation->quantity);
            if (($cart->sum('quantity') + $inputs['quantity']) > $product->quantity) {
                return false;
            }

            // $data = $cart->where('product_id', $inputs['product_id'])->first();
            $data = $cart->where('product_id', $inputs['product_id'])
                ->where('color_id', $inputs['color_id'] ?? null)
                ->where('size_id', $inputs['size_id'] ?? null)
                ->first();

            // Check if existing data
            if ($data) {

                $data->increment('quantity', $inputs['quantity']);
            } else {
                $product = DB::table('products')
                ->where('id', $inputs['product_id'])
                ->first();
                if ($product->quantity < $inputs['quantity']) {
                    return false;
                }

                $this->model->create($inputs);
            }
        } else {
            // Add items to cart
            $product = DB::table('products')
                ->where('id', $inputs['product_id'])
                ->first();
            if ($product->quantity < $inputs['quantity']) {
                return false;
            }
           $this->model->create($inputs);
        }
        return true;
    }

    private function responseData()
    {
        $carts = auth()->check() ? $this->model
            ->select(
                '*',
            )
            ->where('user_id', auth()->user()->id)
            ->where('country_id', session('country')->id)
        // ->whereUserId($this->user()->id)
            ->with('product')->get() : Cart::content();


        $mapping = $carts->map(function ($item) {
            $cost =  $item->product->after_discount * $item->quantity;
            $item->product_total = sprintf('%0.2f', $cost);
            return $cost;
        });

        $total =((number_format(array_sum($mapping->toArray()), 2, '.', '') * session('country')->tax) / 100 + number_format(array_sum($mapping->toArray()), 2, '.', '') + session('country')->shipping);
        $data = [
            'items_count' => $carts->sum('quantity'),
            'sub_total' => number_format(array_sum($mapping->toArray()), 2, '.', ''),
            'shipping' => session('country')->shipping,
            'tax' => (number_format(array_sum($mapping->toArray()), 2, '.', '') * session('country')->tax) / 100,
            'total' => $total,
            'items' => $carts,
        ];
        return $data;
    }


    public function update( Request $request)
    {
        $cart = $this->model->find($request->id);
        $cart->update([
            'quantity' => $request->qty
        ]);
        $carts = $this->responseData();
        $res = [
            'carts' => view('website::cart.includes.cart-body', compact('carts'))->render(),
            'totals' => view('website::cart.includes.totals-sec', compact('carts'))->render(),
        ];

        return responseJson(true, __('lang.updated_successfully'),$res);
    }
}
