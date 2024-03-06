<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Country;
use Modules\Superadmin\Http\Requests\City\StoreCountryRequest;

class CountryController extends Controller
{
    protected $model ;

    public function __construct(Country $model){
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


        return view('superadmin::countries.index',[
            'data' => $this->model->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::countries.form' ,[
            'resource' => $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCountryRequest $request
     * @return Renderable
     */
    public function store(StoreCountryRequest $request)
    {
        $inputs = $request->validated();
        if($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.COUNTRY_PATH'));
        }
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
        return view('superadmin::countries.form' ,[
            'resource' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreCountryRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreCountryRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource =  $this->model->findOrFail($id);
        if ($request->image) {
            $inputs['image'] = uploadImage($inputs['image'],config('path.COUNTRY_PATH') , $resource->image);
        }
       $resource->update($inputs);
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
