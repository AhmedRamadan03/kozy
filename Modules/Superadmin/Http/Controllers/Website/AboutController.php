<?php

namespace Modules\Superadmin\Http\Controllers\Website;

use App\Models\About;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Website\StoreAboutRequest;

class AboutController extends Controller
{
    protected $model;


    public function __construct(About $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('superadmin::website.about.index' ,[
            'resource' => $this->model->first() ?? $this->model,
        ]);
    }


    /**
     * Update the specified resource in storage.
     * @param StoreAboutRequest $request
     * @return Renderable
     */
    public function update(StoreAboutRequest $request)
    {
        $resource = $this->model->first();
        $inputs = $request->validated();
        if(isset($inputs['image']))
        $inputs['image'] = uploadImage($inputs['image'], config('path.ABOUT_PATH'), optional($resource)->image);

        $resource ? $resource->update($inputs) : $this->model->create($inputs);
        toast(__('lang.updated'), 'success');
        return redirect()->route('admin.about.index');
    }

}
