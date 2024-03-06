<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $append = ['full_name'];


    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }




    public function father(){
        return $this->hasOne(Father::class , 'id', 'father_id');
    }

    public function group(){
        return $this->hasOne(Group::class , 'id', 'group_id');
    }

    public function level(){
        return $this->hasOne(Level::class , 'id', 'level_id');
    }

    public function city(){
        return $this->hasOne(City::class , 'id', 'city_id');
    }

    public function studentCourses(){
        return $this->belongsToMany(Course::class, 'student_courses')->withTimestamps();
    }
    public function activeCourses(){
        return $this->studentCourses()->where('is_active',1);
    }


    public function activeCoursesIds(){
        return $this->studentCourses()->where('is_active',1)->pluck('courses.id')->toArray();
    }

    public function activeExams(){
        return $this->belongsToMany(Exam::class, 'exam_assigns')->get();
    }
    /**
     * Get the user's favorite courses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(CourseFavorit::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function getAnswerAssnigments(){
        return $this->hasMany(StudentAssignment::class, 'user_id');
    }


    public function getExams(){
        return $this->hasMany(StudentExam::class, 'user_id')->latest();
    }


    public function getNotifications(){
        return $this->hasMany(ModelNotification::class, 'user_id')->latest();
    }


    public function getNotReadNotifications(){
        return $this->getNotifications()->where('is_read', 0);
    }

    public function getReadNotifications(){
        return $this->getNotifications()->where('is_read', 1);
    }


    public function getAnsweredAssnigment($id){
        $answer =  $this->hasMany(StudentAssignment::class, 'user_id')->where('assignment_id', $id)->first();
        return $answer ? $answer : null;
    }

    public function scopeFilter($query, $request){
        return $query->where(function($q) use ($request){
            if ($request->search) {
                $q->where('first_name', 'like', '%'.$request->search.'%');
                $q->orWhere('last_name', 'like', '%'.$request->search.'%');
                $q->orWhere('email', 'like', '%'.$request->search.'%');
                $q->orWhere('phone', 'like', '%'.$request->search.'%');
            }

            if($request->level_id){
                $q->where('level_id', $request->level_id);
            }
            if($request->group_id){
                $q->where('group_id', $request->group_id);
            }

            if($request->city_id){
                $q->where('city_id', $request->city_id);
            }
        });
    }
}
