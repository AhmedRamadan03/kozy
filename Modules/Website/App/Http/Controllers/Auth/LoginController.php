<?php
namespace Modules\Website\App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */

     protected $redirectTo = '/';


    public function showLoginForm()
    {
        return view('website::auth.login');
    }

     /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
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
        $this->validateLogin($request);
        // dd($credentials);
        $this->authenticated($request, auth()->user());
        toast(__('api.login_successfull'), 'success');
        return redirect()->route('front.home');
    }


    public function logout(Request $request){
        $this->guard()->logout();


        return redirect('/');
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }


    protected function authenticated($request, $user)
    {
        // Check if the user already has an active session
        if ($user->remember_token !== null) {
            // If a session token exists, log out the user from the previous session

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
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
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
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

        /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }


}
