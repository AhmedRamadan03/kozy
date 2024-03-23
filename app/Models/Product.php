<?php

namespace App\Models;

use App\Services\Builders\ProductBuilder;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable,SoftDeletes;

    protected $fillable = ['image','slug','hide','brand_id','category_id','country_id','sku','price','discount','after_discount','quantity'];
    protected $translatedAttributes = ['title','description','short_description','meta_keywords','meta_description'];


    protected $appends = [  'all_images','favorite'];


    /**
     * The boot method is called when the model is booted, and it sets up event listeners for the "saving" event.
     *
     * @param \Closure $callback The callback function to be executed when the "saving" event is triggered
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $id = $model->id;
            if (is_null($id)) {
                $id = (optional($model->latest('id')->first())->id ?? 0) + 1;
            }
            $model->slug = slug($model->translate('en')->title) . '-' . $id;
        });
    }

    public function scopeForDrobDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('country_id',auth()->user()->country_id);
        }else{
            return $query;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('hide', 0);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }



    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function getFavoriteAttribute()
    {
        return DB::table('product_favs')->where('user_id',auth()->user()->id)->where('product_id',$this->id)->exists();
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }
      //get all variations color of product without duplicates
      public function getProSizes($colorId)
      {
          return  ProductVariation::where('product_id', $this->id)->where('color_id', $colorId)->get();
      }
    public function productColors()
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->select('color_id') // Select the desired column for grouping
        ->groupBy('color_id');
    }

    public function getProductSizes($color_id)
    {
        $sizes = DB::table('product_variations')->where('product_id', $this->id)->where('color_id', $color_id)->pluck('size_id')->toArray();
        // dd($sizes);
        return Size::whereIn('id', $sizes)->pluck('name')->toArray();
    }
    // Relations
    public function colors()
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->select('color_id') // Select the desired column for grouping
        ->groupBy('color_id');
    }


    public function getSizes($color_id)
    {
        return DB::table('product_variations')->where('product_id', $this->id)->where('color_id', $color_id)->pluck('size_id')->toArray();
    }

    public function getAllImagesAttribute()
    {
        $images = $this->images->pluck('image')->toArray();
        array_unshift($images, $this->image);
        return $images;
    }



    public function scopeFilter($query)
    {
        if(request()->search)
        {
            return $query->whereTranslationLike('title', '%' . request()->search . '%')
                        ->orWhereTranslationLike('description','%' . request()->search . '%')
                        ->orWhere('sku', 'like', '%' . request()->search . '%');
        }

        if(request()->country_id)
        {
            return $query->where('country_id',request()->country_id);
        }

        if(request()->brand_id)
        {
            return $query->where('brand_id',request()->brand_id);
        }
        if(request()->brand)
        {
            $id = Brand::where('slug',request()->brand)->first()->id;

            return $query->where('brand_id',$id);
        }

        if(request()->category_id)
        {
            return $query->where('category_id',request()->category_id);
        }
        if(request()->category)
        {
            $catId = Category::where('slug',request()->category)->first()->id;
            return $query->where('category_id',$catId);
        }
        if(request()->main_cat)
        {
            $catId = Category::where('slug',request()->main_cat)->first()->id;
            $ids = Category::where('parent_id',$catId)->pluck('id');
            return $query->whereIn('category_id',$ids);
        }

        if(request()->hide)
        {
            return $query->where('hide',request()->hide);
        }

        if (request()->min && request()->max) {
            $query->whereBetween('after_discount', [request()->min, request()->max]);
        }
        if (request()->sort) {
            $query->orderBy('created_at', request()->sort);
        }

        if(request()->discount)
        {
            if(request()->discount == 'yes')
            {
                return $query->where('discount','>',0);
            }else{
                // dd(request()->discount );
                return $query->where('discount',0);

            }
        }
    }


}

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description','meta_keywords','meta_description','short_description'];
    public $timestamps = false;
}
