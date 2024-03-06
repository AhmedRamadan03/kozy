<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];
    public static function setMany($data)
    {
        foreach ($data as $key => $value) {
            // dd([$data,$key,$value]);
            Self::set($key, $value);
        }
    }

    public static function set($key, $value)
    {
        $setting = self::where('key',$key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        }else{
            Setting::create(['key' => $key,'value' => $value]);
        }
    }
}
