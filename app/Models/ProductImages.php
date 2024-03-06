<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';

    protected $fillable = ['image', 'product_id'];

    protected $hidden = [
        'created_at', 'updated_at', 'product_id'
    ];
}
