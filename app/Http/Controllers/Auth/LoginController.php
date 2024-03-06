<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Level;
use App\Providers\RouteServiceProvider;
use App\Utils\ActivityLogUtil;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class LoginController extends Controller
{

    // use AuthenticatesUsers;
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login', [
            'cities' => City::get()->pluck('title', 'id')->toArray(),
            'levels' => Level::get()->pluck('title', 'id')->toArray(),
        ]);
    }


    /**
     * Login Admin
     * @param Login $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {

        // Get Data Credentials Request
        $credentials = $this->credentials($request);
        // Check If Credentials Has Error
        if (!$credentials) {
            return $this->invalid($request);
        }
        // store remember in var if true or false
        $remember = $request->input('remember') ? true : false;
        if (!auth()->attempt($credentials, $remember)) return $this->invalid($request);
        // dd(auth()->user()->is_active);
        if (auth()->user()->is_active == 0) {
            auth()->logout();
            alert()->error('', __('api.blocked_account'));
            return back();
        }
        $browser = Agent::browser();
        $os = Agent::platform();
        $deviceType = Agent::deviceType();

        (new ActivityLogUtil())->actitvityLog(auth()->user()->id, 'login', request()->ip(),  gethostbyaddr(request()->ip()),$browser, $os,$deviceType);
        $this->authenticated($request, auth()->user());
        toast(__('api.login_successfull'), 'success');
        return redirect()->route('front.home');
    }

    /**
     * Filter Member Credentials
     * @param $request
     * @return array|bool
     */
    private function credentials($request)
    {
        $inputs = $request->all();

        if (is_numeric($inputs['email'])) {
            return ['phone' => $inputs['email'], 'password' => $inputs['password']];
        } elseif (filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            return ['email' => $inputs['email'], 'password' => $inputs['password']];
        }
        return false;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    /**
     * Return MSG Error
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function invalid($request)
    {
        alert()->error('', __('api.email_or_password_error'));
        return back();
    }


    protected function authenticated($request, $user)
    {
        // Check if the user already has an active session
        if ($user->remember_token !== null) {
            // If a session token exists, log out the user from the previous session
            auth()->logoutOtherDevices($request->input('password'));

            // Update the session token for the current session
            $user->remember_token = $request->session()->token();
            $user->save();
        } else {
            // If no session token exists, store the current session token
            $user->remember_token = $request->session()->token();
            $user->save();
        }
    }
    /**
     * Logout user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        $browser = Agent::browser();
        $os = Agent::platform();
        $deviceType = Agent::deviceType();

        if (auth()->check()) {
            (new ActivityLogUtil())->actitvityLog(auth()->user()->id, 'logout', request()->ip(),  gethostbyaddr(request()->ip()),$browser, $os,$deviceType);
            auth()->logout();
            request()->session()->invalidate();
        }
        return back();
    }
}
