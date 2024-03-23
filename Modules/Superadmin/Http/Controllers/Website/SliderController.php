<?php

namespace Modules\Superadmin\Http\Controllers\Website;

use App\Models\Slider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Student\ChangeStatus;
use Modules\Superadmin\Http\Requests\Website\StoreSliderRequest;

class SliderController extends Controller
{
    protected $model ;

    public function __construct(Slider $model){
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


        return view('superadmin::website.sliders.index',[
            'data' => $this->model->forDrobDown()->paginate(20)
        ]);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::website.sliders.form' ,[
            'resource' => $this->model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSliderRequest $request
     * @return Renderable
     */
    public function store(StoreSliderRequest $request)
    {
        $inputs = $request->validated();
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage( $inputs['image'] , config('path.SLIDER_PATH'));
        }
        $this->model->create($inputs);
        toast(__('lang.created') , 'success');
        return redirect()->route('admin.slider.index');
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
        return view('superadmin::website.sliders.form' ,[
            'resource' => $this->model->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreSliderRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreSliderRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource = $this->model->findOrFail($id);
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'], config('path.SLIDER_PATH'), $resource->image);
        }
        $resource->update($inputs);
        toast(__('lang.updated'), 'success');
        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $resource = $this->model->findOrFail($id);
        deleteImage($resource->image);
        $resource->delete();
        toast(__('lang.deleted'), 'success');
        return redirect()->route('admin.slider.index');
    }


     /**
     *Change the status of a slider.
     * @param ChangeStatus $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(ChangeStatus $request)
    {
        $inputs = $request->validated();
        $this->model->findOrFail($inputs['id'])->update([
            'is_active' => $inputs['is_active']
        ]);
        return response()->json([
            'success' => true,
            'message' => __('lang.updated')
        ]);
    }
}
