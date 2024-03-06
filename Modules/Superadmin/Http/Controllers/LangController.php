<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    public function changeLang(Request $request)
    {
        $langArr=config('translatable.locales');
        if($request->has('lang')){
            if (in_array($request->get('lang'), $langArr)){
                Session::put('locale', $request->get('lang'));
                return redirect()->back();
            }
        }
        return redirect()->back();
    }
}
