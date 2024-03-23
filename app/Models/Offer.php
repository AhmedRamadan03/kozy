<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = ['image','product_id','start_date','end_date','country_id'];

    public function scopeForDrobDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('country_id',auth()->user()->country_id);
        }else{
            return $query;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', Carbon::now());
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
