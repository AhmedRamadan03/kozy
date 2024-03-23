<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = ['user_id','country_id','name','address','total','sub_total','tax','shipping','discount','after_discount','coupon','payment_method','status','ref','show','admin_notes','user_notes','created_at','updated_at'];

    protected $appends = ['details_count','full_address'];

   protected $statuses = [
        'pending',
        'review_underway',
        'confirmed',
        'preparing',
        'shipping',
        'delivery_progress',
        'delivered',
        'canceled',
        'return',
    ];



    public function scopeForDrobDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('country_id',auth()->user()->country_id);
        }else{
            return $query;
        }
    }




    public function getDetailsCountAttribute()
    {
        return $this->details()->count();
    }
    public function statuses()
    {
        return $this->statuses;
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function generateRefNo()
    {
        $id = sprintf("%0" . 6 . "d", $this->id);
        $ref = date('ymd') . $id;
        $this->update([
            'ref' => $ref,
        ]);
    }


    // Relations
    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function getFullAddressAttribute()
    {
        $address = json_decode($this->address)?? new Order();
        return $address;
    }
    public function address()
    {
        $address = json_decode(json_encode($this->address)) ?? new Order();
        dd($address);
        return $address;
    }


    public static function scopeFilter($query)
    {
        return $query->where(function ($q)  {

            if (request()->search) {
                $q->where('total', 'like', '%' . ltrim(request()->search, '#') . '%');
                $q->orWhere('name', 'like', '%' . ltrim(request()->search, '#') . '%');
                $q->orWhere('address', 'like', '%' . ltrim(request()->search, '#') . '%');
                $q->orWhere('ref', 'like', '%' . ltrim(request()->search, '#') . '%');
            }

            if (request()->status) {
                $q->where('status', request()->status);
            }

            if (request()->datefilter) {
                $date = explode(' - ', request()->datefilter);
                $startDate = date('Y-m-d', strtotime($date[0]));
                $endDate = date('Y-m-d', strtotime($date[1]));
                $q->whereBetween('created_at', [
                        $startDate,
                        $endDate,
                    ]);
            }

            if (request()->country_id) {
                $q->where('country_id',request()->country_id);
            }

            if (request()->start_date) {
                $start_date = Carbon::parse(request()->start_date)->format('Y-m-d H:m:i');
                $q->where('created_at', '>', $start_date);
            }

            if (request()->end_date) {
                $end_date = Carbon::parse(request()->end_date)->format('Y-m-d H:m:i');
                $q->where('created_at', '<', $end_date);
            }
            if (request()->end_date && request()->start_date) {
                $start_date = Carbon::parse(request()->start_date)->format('Y-m-d H:m:i');
                $end_date = Carbon::parse(request()->end_date)->format('Y-m-d H:m:i');
                $q->where('created_at', '<', $end_date);
                $q->orWhere('created_at', '>', $start_date);

            }
        });
    }

}
