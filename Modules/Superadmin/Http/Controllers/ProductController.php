<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Product;
use App\Models\Size;
use App\Services\Builders\ProductBuilder;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Superadmin\Http\Requests\StoreProductRequest;
use Modules\Superadmin\Http\Requests\ChangeStatus;

class ProductController extends Controller
{
    protected $model ;

    public function __construct(Product $model){
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


        return view('superadmin::products.index',[
            'data' => $this->model->forDrobDown()->filter()->paginate(20),
            'categories' => Category::forDrobDown()->child()->get()->pluck('title','id')->toArray(),
            'brands' => Brand::forDrobDown()->get()->pluck('title','id')->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::products.form' ,[
            'data' => $this->model,
            'categories' => Category::forDrobDown()->active()->child()->get()->pluck('title','id'),
            'brands' => Brand::forDrobDown()->active()->get()->pluck('title','id'),
            'colors' => Color::pluck('name','id'),
            'sizes' => Size::pluck('name','id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreProductRequest $request
     * @return Renderable
     */
    public function store(StoreProductRequest $request)
    {
        $inputs = $request->validated();

        $inputs['country_id'] = auth()->user()->country_id ?? Country::first()->id;
        if(empty($inputs['sku'])){
            $inputs['sku'] = str_pad(Product::max('id') + 1, 5, '0', STR_PAD_LEFT);
        }

        try {
            DB::beginTransaction();
            $data = (new ProductBuilder($inputs))
                ->withProduct()
                ->withImage($request->file('image'))
                ->withLog()
                ->withAttributes()
                ->withImages()
                ->build();

            DB::commit();
            toast(__('lang.created'), 'success');


        } catch (\Exception $e) {
            DB::rollBack();
            toast($e->getMessage(), 'error');

        }
        return redirect()->route('admin.product.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('superadmin::products.show', [
            'product' => $this->model->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);
        return view('superadmin::products.form' ,[
            'data' => $this->model->findOrFail($id),
            'categories' => Category::active()->child()->get()->pluck('title','id'),
            'brands' => Brand::active()->get()->pluck('title','id'),
            'colors' => Color::pluck('name','id'),
            'sizes' => Size::pluck('name','id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreProductRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreProductRequest $request, $id)
    {
        $inputs = $request->validated();
        try {
            DB::beginTransaction();
            $data = (new ProductBuilder($inputs))
                ->withEditProduct($id)
                ->withImage($request->file('image'))
                ->withLog()
                ->withAttributes()
                ->withImages()
                ->build();

            DB::commit();

            toast(__('lang.updated'), 'success');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            toast($e->getMessage(), 'error');

        }
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        setLogs('delete', 'category', $data ,$data->toArray() );
        deleteImage($data->image);
        deleteImage($data->icon);
        $data->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }


   /**
     * Delete Images Product
     * @param $id
     * @param $it
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id, $it)
    {
            // Get & Check Data
            $data = $this->model->findOrFail($id);
            // Get Item Data
            $item = $data->images()->find($it);
            // Delete Image
           deleteImage($item->image);
            // Delete Item
           setLogs('delete', 'image', $item, $item->toArray());

            $item->delete();
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


    public function getBrandsAndCategories()
    {
        $brands = Brand::active()->where('country_id',request()->country_id)->get();
        $categories = Category::active()->where('country_id',request()->country_id)->child()->get();
        return response()->json([
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
