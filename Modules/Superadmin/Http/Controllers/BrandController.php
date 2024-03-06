<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Brand;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\StoreBrandRequest;
use Modules\Superadmin\Http\Requests\ChangeStatus;

class BrandController extends Controller
{
    protected $model ;

    public function __construct(Brand $model){
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


        return view('superadmin::brands.index',[
            'data' => $this->model->forDrobDown()->filter()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::brands.form' ,[
            'resource' => $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBrandRequest $request
     * @return Renderable
     */
    public function store(StoreBrandRequest $request)
    {
        $inputs = $request->validated();
        if($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.BRAND_PATH'));
        }
        // $this->model->create($inputs);
        $resource = $this->model->create($inputs);
        setLogs('store', 'brand', $resource  );
        toast(__('lang.created'), 'success');
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
        return view('superadmin::brands.form' ,[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreBrandRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreBrandRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =  $this->model->findOrFail($id);
        $old =  $resource->toArray();

        if ($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.BRAND_PATH') , $resource->image);
        }

        $resource->update($inputs);

        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'brand', $resource, $logData );

        toast(__('lang.updated'), 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        deleteImage($data->image);
       setLogs('delete', 'brand', $data ,$data->toArray() );
        $data->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }


     /**
     *Change the status of a slider.
     * @param ChangeStatus $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(ChangeStatus $request)
    {
        $inputs = $request->validated();
        $resource= $this->model->findOrFail($inputs['id']);
        $old =  $resource->toArray();

        //log data

        $resource->hide = $inputs['is_active'];
        $resource->save();
        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'brand', $resource, $logData );

        return response()->json([
            'success' => true,
            'message' => __('lang.updated')
        ]);
    }
}
