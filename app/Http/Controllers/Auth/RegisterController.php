<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Auth\RegisterRequest;
use App\Models\Father;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

     /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {

        event(new Registered($user = $this->create($request->validated())));
        $user->remember_token = $request->session()->token();
        $user->save();
        $this->guard()->login($user);

       toast(__('api.register_successfull'), 'success');
       return redirect()->route('front.home');


    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $max = Father::max('id') + 1;
        $email = 'father'.$max.'@gmail.com';
        $father = Father::create([
            'phone' => $data['father_phone'],
            'first_name' => $data['last_name'],
            'last_name' => $data['last_name'],
            'email' =>  $email,
            'password' => Hash::make($data['last_name']),
        ]);

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'father_id' => $father->id,
            'phone' => $data['phone'],
            'level_id' => $data['level_id'],
            'city_id' => $data['city_id'],
            'group_id' => $data['group_id'],
            'is_active' => 0
        ]);
    }


/**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
