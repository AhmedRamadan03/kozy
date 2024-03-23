<?php

namespace Modules\Website\App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductFav;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class FavController extends Controller
{
    protected $model;

    public function __construct(ProductFav $model)
    {
        $this->model = $model;
    }


   public function index()
   {
    $proIds= $this->model->pluck('product_id')->toArray();
    $products = Product::whereIn('id',$proIds)->get();
       return view('website::profile.products-fav',[
           'products' =>$products
       ]);
   }


   public function store(Request $request)
   {

      if (DB::table('product_favs')->where('user_id',auth()->user()->id)->where('product_id',$request->product_id)->exists()) {
            return response()->json(['status' => false,'message' => 'Already Added To Favourites']);
      } else {
        $this->model->create([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['status' => true,'message' => __('front.product_add_to_fav')]);
      }

   }


   public function remove(Request $request)
   {

       $this->model->where('user_id',auth()->user()->id)->where('product_id',$request->product_id)->delete();
    if (request()->ajax()) {
        # code...
        return response()->json(['status' => true,'message' => __('front.product_remove_from_fav')]);
    }else{
        toast(__('front.product_remove_from_fav'), 'success');
        return back();
    }

   }
}
