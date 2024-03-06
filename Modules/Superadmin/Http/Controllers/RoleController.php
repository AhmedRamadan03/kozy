<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{

    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);

        return view('superadmin::roles.index',[
            'data'=> $this->model->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::roles.form',[
            'permissions' => Permission::get()->groupBy('path'),
            'resource' => $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreRoleRequest $request)
    {
        $inputs = $request->validated();
        $permissions = $inputs['permissions'];
        unset($inputs['permissions']);
        $resource = Role::create($inputs);
        $resource->syncPermissions($permissions);
        toast(__('lang.created'), 'success');
        return redirect(route('admin.role.index'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('store::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $resource = $this->model->findOrFail($id);
        return view('superadmin::roles.form', [
            'permissions' => Permission::get()->groupBy('path'),
            'resource' => $resource,
            'rolePermissions' => $resource->permissions->pluck('id')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreRoleRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreRoleRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =$this->model->findOrFail($id);
        $permissions = $inputs['permissions'];
        unset($inputs['permissions']);
        $resource->update($inputs);
        $resource->syncPermissions($permissions);
        toast(__('lang.updated'),'success');
        return redirect(route('admin.role.index'));

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();
       toast(__('admin.deleted'),'success');
       return back();
    }
}

