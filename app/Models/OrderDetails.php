<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order_details';


    protected $fillable = ['order_id','product_id','product_details','cost','quantity','color_id','size_id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function color(){
        return $this->BelongsTo(Color::class, 'color_id');
    }

    public function size(){
        return $this->BelongsTo(Size::class, 'size_id');
    }


}
