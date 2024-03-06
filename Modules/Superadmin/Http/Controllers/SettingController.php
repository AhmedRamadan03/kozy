<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{

    protected $model;

    public function __construct(Setting $model){
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('superadmin::settings.index' , ['settings' => $this->model->all()]);
    }

   public function update(Request $request){
        $setting = $this->model->all();
        $inputs = $request->except('_token');
        if (isset($inputs['logo'])) {
            $inputs['logo'] = uploadImage($inputs['logo'] , config('path.SETTING_PATH') , optional($setting->where('key','logo')->first())->value);
        }

        if (isset($inputs['logo_white'])) {
            $inputs['logo_white'] = uploadImage($inputs['logo_white'] , config('path.SETTING_PATH') , optional($setting->where('key','logo_white')->first())->value);
        }

        if (isset($inputs['favicon'])) {
            $inputs['favicon'] = uploadImage($inputs['favicon'] , config('path.SETTING_PATH') , optional($setting->where('key','favicon')->first())->value);
        }
        if (isset($inputs['login_image'])) {
            $inputs['login_image'] = uploadImage($inputs['login_image'] , config('path.SETTING_PATH') , optional($setting->where('key','login_image')->first())->value);
        }
        if (isset($inputs['courses_bannar'])) {
            $inputs['courses_bannar'] = uploadImage($inputs['courses_bannar'] , config('path.SETTING_PATH') , optional($setting->where('key','courses_bannar')->first())->value);
        }
        $this->model->setMany($inputs);
        toast(__('lang.updated') , 'success');
        return redirect()->back();
   }
}
