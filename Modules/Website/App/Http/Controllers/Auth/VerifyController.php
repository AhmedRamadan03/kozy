<?php

namespace Modules\Website\App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\DB;
use Modules\Website\App\Http\Requests\VerifyUserRequest;

class VerifyController extends Controller
{

    public function index()
    {
        return view('website::auth.verify');
    }

   /**
     * Verify Seller Account
     * @param VerifyUser $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify(VerifyUserRequest $request)
    {
        /// Get Inputs From Request
        $inputs = $request->validated();
        // Get Member Related to Request Code
        $user = User::where('verification_key', $inputs['verification_key'])->first();
        // $from = Carbon::parse($user->date_verify_key)->addMinutes(60)->format('Y-m-d H:i:s');
        // $to = Carbon::now()->format('Y-m-d H:i:s');
        // // Check If Date Verify Key
        // if($to > $from) {
        //     $this->flash('error', __('lang.invalid_code'));
        //     return back()->withInput($request->all());
        // }
        DB::beginTransaction();
        $user->status = 'active';
        $user->verification_key = null;
        $user->save();
        DB::commit();
        // Delete cookie user id and set the same cookie but have a null value
        unset($_COOKIE['id']);
        setcookie('id', null, -1, '/');
       toast(__('lang.verify_success'), 'success');
        return redirect(route('login'));
        //return view('front.auth.store_info');
    }
}
