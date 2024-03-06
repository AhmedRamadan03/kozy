<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\City;
use App\Models\Country;
use Modules\Superadmin\Http\Requests\City\StoreCityRequest;

class CityController extends Controller
{
    protected $model ;

    public function __construct(City $model){
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


        return view('superadmin::cities.index',[
            'data' => $this->model->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::cities.form' ,[
            'resource' => $this->model,
            'countries' => Country::get()->pluck('title' , 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCityRequest $request
     * @return Renderable
     */
    public function store(StoreCityRequest $request)
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
        return view('superadmin::cities.form' ,[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreCityRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreCityRequest $request, $id)
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
}
