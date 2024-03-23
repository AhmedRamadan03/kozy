<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $table = "to_dos";

    protected $fillable = ['user_id','created_by','subject','task','end_date','status','notes'];

    public const STATUS = [
        'pending',
        'process',
        'hold',
        'complet',
    ];


    public function scopeForDropDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('user_id',auth()->user()->id)->orWhere('created_by',auth()->user()->id);
        }else{
            return $query;
        }
    }
}
