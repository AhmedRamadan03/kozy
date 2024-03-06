<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = ['user_id','country_id','username','address','total','sub_total','tax','shipping_fees','discount','after_discount','coupon','payemnt_method','status','ref','show'];


    public const STATUS = [
        'pending',
        'preparation',
        'shipping',
        'reached',
        'canceled',
        'returned',
    ];


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
