<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\StoreColorAndSizeRequest;
use Modules\Superadmin\Http\Requests\ChangeStatus;

class OrderController extends Controller
{
    protected $model ;

    public function __construct(Order $model){
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


        return view('superadmin::colors.index',[
            'data' => $this->model->paginate(20),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::colors.form' ,[
            'resource' => $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreColorAndSizeRequest $request
     * @return Renderable
     */
    public function store(StoreColorAndSizeRequest $request)
    {
        $inputs = $request->validated();

        // $this->model->create($inputs);
        $resource = $this->model->create($inputs);
        setLogs('store', 'color', $resource  );
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
        return view('superadmin::colors.form' ,[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreColorAndSizeRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreColorAndSizeRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =  $this->model->findOrFail($id);
        $old = $resource->toArray();


        $resource->update($inputs);

        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'color', $resource, $logData );

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
        setLogs('delete', 'color', $data,$data->toArray()  );
        $data->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }


}
