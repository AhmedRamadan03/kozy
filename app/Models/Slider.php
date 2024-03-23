<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable =['image','country_id','in_active'];

    protected $appends = ['image_url'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }


    public function scopeForDrobDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('country_id',auth()->user()->country_id);
        }else{
            return $query;
        }
    }


    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }

}
