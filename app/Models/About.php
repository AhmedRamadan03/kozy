<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class About extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    protected $translatedAttributes = ['title', 'short_description', 'description'];

    protected $guarded =[];


}

