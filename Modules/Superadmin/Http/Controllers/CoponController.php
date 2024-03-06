<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Copon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Copon\StoreCoponRequest;
use Modules\Superadmin\Http\Requests\Student\ChangeStatus;

class CoponController extends Controller
{


    protected $model ;

    public function __construct(Copon $model){
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


        return view('superadmin::copons.index',[
            'data' => $this->model->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::copons.form' ,[
            'resource' => $this->model,
            'discount_types' => Copon::DISCOUNT_TYPES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCoponRequest $request
     * @return Renderable
     */
    public function store(StoreCoponRequest $request)
    {
        $inputs = $request->validated();
        $this->model->create($inputs);
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
        return view('superadmin::copons.form' ,[
            'resource' => $this->model->findOrFail($id),
            'discount_types' => Copon::DISCOUNT_TYPES
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreCoponRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreCoponRequest $request, $id)
    {
        $inputs = $request->validated();
        $this->model->findOrFail($id)->update($inputs);
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
        $this->model->findOrFail($id)->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }


    /**
     * change status of student
     * @param ChangeStatus $request
     * @return json
     */
    public function changeStatus(Request $request){
        $inputs = $request->all();
        $resourse = $this->model->find($inputs['id']);
        $resourse->update([
            'status' => $inputs['is_active']
        ]);
        return response()->json([
            'success' => true,
            'message' => __('lang.updated')
        ]);
    }
}
