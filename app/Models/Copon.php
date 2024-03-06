<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copon extends Model
{
    use HasFactory;


    protected $guarded= [];

    public const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    public const DISCOUNT_TYPE_FIXED = 'fixed';

    public const DISCOUNT_TYPES = [
        'percentage' => self::DISCOUNT_TYPE_PERCENTAGE,
        'fixed' => self::DISCOUNT_TYPE_FIXED
    ];
}
