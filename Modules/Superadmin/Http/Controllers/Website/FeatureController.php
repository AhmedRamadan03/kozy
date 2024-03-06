<?php

namespace Modules\Superadmin\Http\Controllers\Website;

use App\Models\Feature;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Website\StoreFeatureRequest;

class FeatureController extends Controller
{
    protected $model ;

    public function __construct(Feature $model){
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
        return view('superadmin::website.features.index',[
            'data' => $this->model->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::website.features.form',[
            'resource' => $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreFeatureRequest $request
     * @return Renderable
     */
    public function store(StoreFeatureRequest $request)
    {
        $inputs = $request->validated();
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'], config('path.FEATURE_PATH'));
        }
        if (isset($inputs['icon'])) {
            $inputs['icon'] = uploadImage($inputs['icon'], config('path.FEATURE_PATH'));
        }
        $this->model->create($inputs);
        toast(__('lang.created'),'success');
        return redirect()->route('admin.feature.index');
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
        return view('superadmin::website.features.form',[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreFeatureRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreFeatureRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource = $this->model->findOrFail($id);
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'], config('path.FEATURE_PATH'), $resource->image);
        }
        if (isset($inputs['icon'])) {
            $inputs['icon'] = uploadImage($inputs['icon'], config('path.FEATURE_PATH'), $resource->icon);
        }
        $resource->update($inputs);
        toast(__('lang.updated'),'success');
        return redirect()->route('admin.feature.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $resource = $this->model->findOrFail($id);
        //delete image
        deleteImage($resource->image);
        //delete icon
        deleteImage($resource->icon);
        $resource->delete();
        toast(__('lang.deleted'),'success');
        return redirect()->route('admin.feature.index');
    }
}
