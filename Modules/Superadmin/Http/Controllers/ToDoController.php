<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Country;
use App\Models\ToDo;
use Modules\Superadmin\Http\Requests\StoreTodoRequest;

class ToDoController extends Controller
{
    protected $model ;

    public function __construct(ToDo $model){
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


        return view('superadmin::todos.index',[
            'data' => $this->model->forDropDown()->paginate(20),
            'status' => ToDo::STATUS
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::todos.form' ,[
            'resource' => $this->model,
            'members' => Admin::forDropDown()->pluck('username','id')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTodoRequest $request
     * @return Renderable
     */
    public function store(StoreTodoRequest $request)
    {
        $inputs = $request->validated();

        $inputs['created_by'] = auth()->user()->id;
        // dd($inputs);
        $resource =  $this->model->create($inputs);
        setLogs('store', 'todo', $resource  );

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
        return view('superadmin::todos.show',[
            'resource' => $this->model->findOrFail($id),
            'status' => ToDo::STATUS

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('superadmin::todos.form' ,[
            'resource' => $this->model->findOrFail($id),
            'members' => Admin::forDropDown()->pluck('username','id')->toArray(),
            'status' => ToDo::STATUS


        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreTodoRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreTodoRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =  $this->model->findOrFail($id);
        $old = $resource->toArray();

        $resource->update($inputs);

        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'todo', $resource, $logData );

        toast(__('lang.updated'), 'success');
        return back();
    }


    public function getNotesModal($id)
    {
        $data = $this->model->findOrFail($id);
        return view('superadmin::todos.notes_modal', compact('data'));
    }

    public function saveNotes(Request $request)
    {
        $data = $this->model->findOrFail($request->id);
        $data->notes = $request->notes;
        $data->save();
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
        setLogs('delete', 'todo', $data,$data->toArray()  );
        $data->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }

     /**
     *Change the status of a slider.
     * @param ChangeStatus $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $inputs = $request->only('status','id');
        $resource= $this->model->findOrFail($inputs['id']);
        $old= $resource->toArray();
        //log data

        $resource->status = $inputs['status'];
        $resource->save();
        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'todo', $resource, $logData );
        toast(__('lang.updated'), 'success');
        return back();

    }
}
