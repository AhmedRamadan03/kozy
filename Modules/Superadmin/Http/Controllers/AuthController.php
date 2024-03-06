<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Auth\AdminLogin;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function view()
    {
        return view('superadmin::auth.login');
    }

         /**
     * Login Admin
     * @param Login $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(AdminLogin $request)
    {
         // Get Data Credentials Request
         $credentials = $this->credentials($request);
        //  dd($credentials);
         // Check If Credentials Has Error
         if(!$credentials) { return $this->invalid($request); }
         // store remember in var if true or false
         $remember = $request->input('remember') ? true : false;
         if(!auth('admin')->attempt($credentials, $remember) ) return $this->invalid($request);
        toast(__('api.login_successfull'), 'success');
        return redirect()->route('admin.home');
    }

    /**
     * Filter Member Credentials
     * @param $request
     * @return array|bool
     */
    private function credentials($request)
    {
        $inputs = $request->validated();

        if(is_numeric($inputs['email'])) {
            return ['phone' => $inputs['email'], 'password' => $inputs['password']];
        }
        elseif (filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            return ['email' => $inputs['email'], 'password' => $inputs['password']];
        }
        return false;
    }


      /**
     * Return MSG Error
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function invalid($request)
    {
        alert()->error('',__('api.email_or_password_error'));
        return back();
    }

       /**
     * Logout Admin
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        if(auth('admin')->check()){
            auth('admin')->logout();
            request()->session()->invalidate();
        }
        return redirect(route('admin.view_login'));
    }

}
