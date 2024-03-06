<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\DashBoardIndexDataBuilder;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $dashboardIndexDataBuilder = new DashBoardIndexDataBuilder();
        $data = $dashboardIndexDataBuilder
                ->getTotals()

                ->build();
        $totals = $data['totals'];


        return view('superadmin::index', compact('totals'));
    }


    public function profile()
    {
        return view('superadmin::profile.index',[
            'resource' => auth('admin')->user(),
        ]);
    }


    public function updateProfile(Request $request)
    {
        $inputs = $request->except('password', 'image');
       //check if password
       $admin = Admin::findOrFail(auth('admin')->user()->id);
       if ($request->password) {
        $inputs['password'] = bcrypt($request->password);
       }
       //check if image
       if ($request->image) {
       $inputs['image'] = uploadImage($request->image , config('path.ADMIN_PATH'),$admin->image);
       }

       $admin->update($inputs);
       alert()->success('',__('lang.profile_updated_successfully'));
       return back();

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('superadmin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('superadmin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
