<?php

namespace  Modules\Superadmin\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Superadmin\Http\Requests\StoreOfferRequest;

class OfferController extends Controller
{

    protected $model ;

    public function __construct(Offer $model){
        $this->model = $model;
    }

    public function index()
    {
        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);

        return view('superadmin::offers.index' ,[
            'data' => $this->model->paginate(20),
        ]);
    }

     /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::offers.form' ,[
            'resource' => $this->model,
        ]);
    }


      /**
     * Store a newly created resource in storage.
     * @param StoreOfferRequest $request
     * @return Renderable
     */
    public function store(StoreOfferRequest $request)
    {
        $inputs = $request->validated();

        // dd($inputs);
        $this->model->create($inputs);
        toast(__('lang.created') , 'success');
        return redirect()->route('admin.offer.index');
    }


      /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('superadmin::offers.form' ,[
            'resource' => $this->model->findOrFail($id),

        ]);
    }



    /**
     * Update the specified resource in storage.
     * @param StoreOfferRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreOfferRequest $request, $id)
    {
        $inputs = $request->validated();
        $resource = $this->model->findOrFail($id);

        // dd($inputs);
        $resource->update($inputs);
        toast(__('lang.updated'), 'success');
        return redirect()->route('admin.offer.index');
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
        return redirect()->route('admin.offer.index');
    }



    public function searchProduct()
    {

        if (request()->search) {
    return $products = Product::forDrobDown()->join('product_translations', 'products.id', '=', 'product_translations.product_id')
        ->where('product_translations.title', 'LIKE', '%' . request()->search . '%')
        ->where('product_translations.locale', app()->getLocale())
        ->select(DB::raw('product_translations.title as text'), 'products.id')
        ->get();
        }
    }
}
