<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Superadmin\Http\Requests\Admin\StoreAdminRequest;

class AdminController extends Controller
{


    protected $model ;

    public function __construct(Admin $model){
        $this->model = $model;
    }



    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);
        $models = $this->model->where('username','!=','admin');
        return view('superadmin::admins.index',[
            'data' => $models->latest()->paginate(20),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::admins.form' , [
         'resource' => $this->model,
         'roles' => Role::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAdminRequest $request
     * @return Renderable
     */
    public function store(StoreAdminRequest $request)
    {
        $inputs = $request->validated();
        $inputs['password'] = Hash::make($inputs['password']);
        if($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.ADMIN_PATH'));
        }
        $resource = $this->model->create($inputs);
        // assign roles to the resource
        if($request->role_id)
            $resource->syncRoles([$request->role_id]);
        toast(__('lang.created'),'success');
        return redirect()->route('admin.admin.index');

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
        return view('superadmin::admins.form' , [
            'resource' => $this->model->findOrFail($id),
            'roles' => Role::get(),
           ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreAdminRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreAdminRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource = $this->model->findOrFail($id);

        if($request->password){
            $inputs['password'] = Hash::make($inputs['password']);
        }else{
            unset($inputs['password']);
        }
        if ($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.ADMIN_PATH') , $resource->image);
        }
        if($request->role_id)
        $resource->syncRoles([$request->role_id]);
        $resource->update($inputs);
        toast(__('lang.updated') , 'success');
        return redirect()->route('admin.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $resource = $this->model->findOrFail($id);
        if ($resource->image) {
            deleteImage($resource->image);
        }
        $resource->delete();

        toast(__('lang.deleted') , 'success');
         return back();
    }


    public function autoLogin($id)
    {
        $resource = $this->model->findOrFail($id);
        auth()->guard('admin')->login($resource);
        return redirect()->route('admin.home');
    }
}
