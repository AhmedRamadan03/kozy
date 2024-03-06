<?php

namespace App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Brand extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = ['image','slug','hide','country_id'];
    protected $translatedAttributes = ['title'];

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


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function scopeFilter($query)
    {
        if(request()->country_id)
        {
            return $query->where('country_id',request()->country_id);
        }
    }
}
