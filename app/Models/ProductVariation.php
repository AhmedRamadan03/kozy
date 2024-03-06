<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function getQuantity($id = null)
    {
        return $this->product_id == $id ? null : optional($this->product)->quantity;
    }

}
