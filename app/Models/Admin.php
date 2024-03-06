<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;

class Admin extends Authenticatable
{

    use HasFactory;
    use LaratrustUserTrait;

    protected $table = 'admins';

    protected $fillable = [
        'username', 'email', 'password', 'image','phone','country_id','show_all'
    ];


    public function scopeForDropDown($query)
    {
        if(auth()->user()->show_all == 0){
            return $query->where('country_id',auth()->user()->country_id)->where('show_all',0)->where('id','!=', auth()->user()->id);
        }else{
            return $query->where('id','!=', auth()->user()->id);
        }
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function hasPermission($permission, $team = null, $requireAll = false)
    {
        $role = $this->roles()->first();
        if (auth('admin')->user()->email == 'admin@gmail.com') {
            return true;
        }

        return $this->laratrustUserChecker()->currentUserHasPermission(
            $permission,
            $team,
            $requireAll
        );
    }
}
