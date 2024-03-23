<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Website\App\Http\Requests\StoreCartRequest;
use Modules\Website\App\Http\Requests\StoreOrderRequest;

class CheckoutController extends Controller
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
        $cartData = $this->model->where('user_id',auth()->user()->id)
            ->where('country_id',session('country')->id)->with('product')->get();
        if(!count($cartData))return redirect()->route('front.cart.cart');
        $CheckoutData = $this->CheckoutData($cartData);
        return view('website::checkout.index',[
            'CheckoutData' =>$CheckoutData,
            'cartData' =>$cartData,
            'countries' => Country::get(),
        ]);
    }


     /**
     * Store Order Data in DB
     * @param StoreOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        // Get Inputs From Request
        $inputs = $request->validated();
        $inputs_data = [
            'country_id' => session('country')->id,
            'name' => auth()->user()->name,
            'payment_method' => $inputs['payment_method'],
            'user_id'         => auth()->user()->id,
        ];
        // Address Information
        $address = [
            'name'         => $inputs['name'],
            'phone'             => $inputs['phone'],
            'postal_code'       => $inputs['postal_code'],
            'district'          => $inputs['district'],
            'street'            => $inputs['street'],
            'notes'             => $inputs['notes'],
        ];
        // Get Data From Cart Related To User Logged
        $cartData = $this->model->where('user_id',auth()->user()->id)->where('country_id',session('country')->id)->with('product')->get();
        // If Not Get Count CartData
        if(!count($cartData)) abort(404);
        // Get Checkout Data
        // dd($cartData);
        $checkoutData = $this->CheckoutData($cartData, $address);


        $sendData = array_merge($inputs_data, $checkoutData);
        // dd($sendData);

        $this->storeOrder($sendData, $cartData, $address);
        toast('Order Placed Successfully', 'success');
        return redirect(route('front.profile.my-orders'));
    }



    /**
     * Store Order Data
     * @param $inputs
     * @param $cartData
     * @param $address
     * @param $paymentResponse
     * @return void
     */
    private function storeOrder($inputs, $cartData, $address, $paymentResponse = null)
    {
        // Set Merge Data
        $pushing_data = [

            'address' => json_encode($address),
        ];

        // Merge Checkout Data With Inputs Request With Pushing Data
        $data = array_merge($inputs, $pushing_data);
        // dd($data);

        // Set An Empty Array Details
        $details = [];
        // Loop On Cart Data
        foreach ($cartData as $get) {
            // Set product details

            $details[] = [
                'product_id' => $get->product_id,
                'cost' => $get->cost,
                'quantity' => $get->quantity,
                'color_id' => $get->color_id ,
                'size_id' => $get->size_id

            ];
        }
        // Store Order
        DB::beginTransaction();

        $order =Order::create($data);

        // generate ref no

        $order->generateRefNo();

        // Assign Order To Details
        $order->details()->createMany($details);



        // Assign Order To Process
        // $order->process()->createMany($this->process($inputs));
        // Decrement Products
        $this->decrementProducts($details);
        // Delete Cart Data
        $this->model->where('user_id',auth()->user()->id)->where('country_id',session('country')->id)->delete();

        session()->put("wallet_price", null);

        // sync order with mylers
        //$order->syncWithMylers();

        DB::commit();
        return $order;
    }



        /**
     * Decrement Quantity From Products Stock
     * @param $details
     */
    private function decrementProducts($details)
    {
        foreach ($details as $get) {
            // dd($details);
            // Decrement QTY From Product
            $product = Product::where('id', $get['product_id'])->first();
            $product->decrement('quantity', $get['quantity']);
        }
    }

    public function getCities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        return response()->json($cities);
    }


/**
     * Get Checkout Data
     * @param $cartData
     * @param $address
     * @param $coupon
     * @return array
     */
    private function CheckoutData($cartData, $address = [])
    {
        // Set Subtotal
        $subtotal = sprintf('%0.2f', $cartData->sum('cost'));
        $data = ['sub_total' => $subtotal];

        // Set Tax
        $data['tax'] = ($subtotal * session('country')->tax) / 100;
        // Set Shipping

        $data['shipping'] = session('country')->shipping;

        $total = ($data['after_discount'] ?? $subtotal) + $data['tax'] + $data['shipping'];
        // Set Total
        $data['total'] = sprintf('%0.2f', $total);
        return $data;
    }


}
