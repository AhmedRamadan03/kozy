<?php

namespace App\Models;



use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Country extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $fillable = ['image','tax','currency'];
    protected $translatedAttributes = ['title'];


}
