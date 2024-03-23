<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\StoreCategoryRequest;
use Modules\Superadmin\Http\Requests\ChangeStatus;

class SubCategoryController extends Controller
{
    protected $model ;

    public function __construct(Category $model){
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {

        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);


        return view('superadmin::sub-categories.index',[
            'data' => $this->model->where('parent_id', $id)->paginate(20),
            'mainCategory' => $this->model->findOrFail($id),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {
        return view('superadmin::sub-categories.form' ,[
            'resource' => $this->model,
            'mainCategory' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCategoryRequest $request
     * @return Renderable
     */
    public function store(StoreCategoryRequest $request)
    {
        $inputs = $request->validated();
        if($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.CATEGORY_PATH'));
        }
        if($request->icon) {
            $inputs['icon'] = uploadImage($inputs['icon'],config('path.CATEGORY_PATH'));
        }

        $inputs['country_id'] = Category::where('id',$inputs['parent_id'])->first()->country_id;
        // $this->model->create($inputs);
        $resource = $this->model->create($inputs);
        setLogs('store', 'category', $resource  );
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
        return view('superadmin::sub-categories.form' ,[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreCategoryRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =  $this->model->findOrFail($id);
        $old = $resource->toArray();
        if ($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.CATEGORY_PATH') , $resource->image);
        }
        if ($request->icon) {
            $inputs['icon'] = uploadImage($inputs['icon'],config('path.CATEGORY_PATH') , $resource->icon);
        }

        $resource->update($inputs);

        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'category', $resource, $logData );

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
        setLogs('delete', 'category', $data,$data->toArray()  );
        deleteImage($data->image);
        deleteImage($data->icon);
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
        $old= $resource->toArray();
        //log data

        $resource->hide = $inputs['is_active'];
        $resource->save();
        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'category', $resource, $logData );

        return response()->json([
            'success' => true,
            'message' => __('lang.updated')
        ]);
    }
}
