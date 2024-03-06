<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Student\UpdateChangePassword;
use App\Http\Requests\Website\Student\UpdateProfile;
use App\Models\City;
use App\Models\Level;
use App\Models\ModelNotification;
use App\Models\User;
use App\Services\Website\DashBoardOfStudentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {

        $data = (new DashBoardOfStudentBuilder())
                ->getTotals()
                ->build();

        // dd($data);
        return view('website.student.dashboard',[
            'data' => $data
        ]);
    }


    public function profile()
    {
        return view('website.student.profile',[
            'student' => User::FindOrFail(auth()->user()->id),
            'cities' => City::get()->pluck('title','id')->toArray(),
            'levels' => Level::get()->pluck('title','id')->toArray(),

        ]);
    }

    public function logs()
    {
        return view('website.student.activity-logs',[
            'logs' => DB::table('user_logs')->where('user_id' , auth()->user()->id)->latest()->paginate(20)
        ]);
    }

/**
     * Update Profile
     * @param UpdateProfile $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProfile $request)
    {
        // Get ID Admin From Auth
        $data = User::where('id' , auth()->user()->id)->first();
        // Get Data From Request
        $inputs = $request->validated();
        // Set Image AT Inputs Request
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'] , config('path.STUDENT_PATH') , $data->image);
        }
        // Update Data
        $data->update($inputs);
        toast(__('lang.profile_updated_successfully'), 'success');
        return redirect()->back();
    }


      /**
     * Update changePassword
     * @param UpdateChangePassword $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(UpdateChangePassword $request)
    {
        $inputs = $request->validated();
        // Get user logged data
        $data = User::where('id' , auth()->user()->id)->first();
        // Check hashed old password
        if (!Hash::check($inputs['old_password'], $data->password)){
            toast(__('lang.password_doesnt_matched'), 'error');
            return back();
        }
        // update password
        $data->update(['password' => bcrypt($inputs['new_password'])]);
        // Logout from other devices
        // Auth::logoutOtherDevices($inputs['new_password']);
        toast(__('lang.password_updated_successfully'), 'success');
        return back();
    }



    public function readNotifications(Request $request)
    {
        ModelNotification::where('user_id' , auth()->user()->id)->where('id' , $request->id)->update(['is_read' => 1]);
        return responseJson(true, __('lang.success'));
    }
}
