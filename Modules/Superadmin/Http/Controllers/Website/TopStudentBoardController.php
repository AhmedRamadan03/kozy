<?php

namespace Modules\Superadmin\Http\Controllers\Website;

use App\Models\StudentBoard;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\Student\ChangeStatus;
use Modules\Superadmin\Http\Requests\TopStudent\StoreTopStudentRequest;

class TopStudentBoardController extends Controller
{
    protected $model ;

    public function __construct(StudentBoard $model){
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
        return view('superadmin::website.students-board.index',[
            'data' => $this->model->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::website.students-board.form',[
            'resource' => $this->model,
            'users' => User::where('is_active',1)->pluck('name','id')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTopStudentRequest $request
     * @return Renderable
     */
    public function store(StoreTopStudentRequest $request)
    {
        $inputs = $request->validated();
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'], config('path.STUDENT_BOARD'));
        }

        $this->model->create($inputs);
        toast(__('lang.created'),'success');
        return redirect()->route('admin.board.index');
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
        return view('superadmin::website.students-board.form',[
            'resource' => $this->model->findOrFail($id),
            'users' => User::where('is_active',1)->pluck('name','id')->toArray(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreTopStudentRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreTopStudentRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource = $this->model->findOrFail($id);
        if (isset($inputs['image'])) {
            $inputs['image'] = uploadImage($inputs['image'], config('path.STUDENT_BOARD'), $resource->image);
        }
        $resource->update($inputs);
        toast(__('lang.updated'),'success');
        return redirect()->route('admin.board.index');
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
        $resource->delete();
        toast(__('lang.deleted'),'success');
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
        $this->model->findOrFail($inputs['id'])->update([
            'is_active' => $inputs['is_active']
        ]);
        return response()->json([
            'success' => true,
            'message' => __('lang.updated')
        ]);
    }
}
