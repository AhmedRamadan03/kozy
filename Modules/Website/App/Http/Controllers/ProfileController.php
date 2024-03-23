<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Partener;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Website\App\Http\Requests\UpdatePasswordRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('website::profile.index',[
            'countries'=> Country::all(),
        ]);
    }


    public function updateProfile(Request $request)
    {
        $inputs = $request->only('image','name','email','phone','country_id');

        if (isset($inputs['image'])) {
            $inputs['image'] = uploadFile($inputs['image'],config('upload_pathes.users'),auth()->user()->image);
        }
        $user = auth()->user();
        $user->update($inputs);
        toast(__('front.profile_updated'),'success');
        return redirect()->back();
    }


    public function updatePassword(Request $request)
    {
        $inputs = $request->except('_token');
        if ($inputs['new_password'] != $inputs['confirm_password']) {
            toast(__('front.password_not_matched'),'error');
            return redirect()->back();
        }
        // dd($inputs);
        if (Hash::check($inputs['current_password'], auth()->user()->password)) {
            auth()->user()->update(['password' => bcrypt($inputs['new_password'])]);
            toast(__('front.password_changed'),'success');
            return redirect()->back();
        }else{
            toast(__('front.password_not_changed'),'error');
            return redirect()->back();
            # code...
        }
    }


    public function myOrders()
    {
        $title = __('front.cancled_order');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);
        return view('website::profile.my-orders',[
            'orders' => Order::where('user_id',auth()->user()->id)->latest()->get(),
        ]);
    }


    public function cancelOrder($ref)
    {
        $order = auth()->user()->orders()->where('ref', $ref)->first();
        $order->update(['status' => 'canceled']);
        toast(__('front.order_canceled'),'success');
        return redirect()->back();
    }


}
