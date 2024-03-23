<?php
namespace Modules\Website\App\Http\Controllers\Auth;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Website\App\Http\Requests\RegisterRequest;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

     /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('website::auth.register',[
            'countries' => Country::get(),

        ]);
    }

      /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
       $data = $request->validated();
       $data['password'] = bcrypt($request->input('password'));

       // Set Verification Key In data Request
    //    $data['verification_key'] = $this->keyUser('verification_key');
       DB::beginTransaction();
       $user  = User::create($data);

    //    Send Notification To User Via $this->via

    //    if (isset($inputs['phones'])) {
    //       NotificationUtil::sendSmsWithCode($inputs['country_code'], [$inputs['phones']], __('lang.msegat_msg') . $inputs['verification_key']);
    //    }else  {
    //        $data->notify(new AccountConfirmation($inputs['verification_key'], $inputs['email']));

    //    //}
       DB::commit();
       toast(__('lang.register_success'), 'success');
        return redirect(route('login'));
        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //             ? new JsonResponse([], 201)
        //             : redirect($this->redirectPath());
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Modules\Website\App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

      /**
     * Generate Code
     * @return string
     */
    private function codeGenerate()
    {
        return mt_rand(1000, 9999);
    }
    private function keyUser($field)
    {
        do {
            $key = $this->codeGenerate();
            $user = User::where($field, $key)->first();
        } while ($user);

        return $key;
    }
}
