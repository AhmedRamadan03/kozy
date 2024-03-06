<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Favorite\CheckFavorite;
use App\Models\Course;
use App\Models\CourseFavorit;
use Illuminate\Http\Request;

class FavoriteContoller extends Controller
{
    protected $model;

    public function __construct(CourseFavorit $model){
        $this->model = $model;

    }

    public function index()
    {
        return view('website.student.favorite.index',[
            'data' => $this->model->with('course')->where('user_id',auth()->user()->id)->get()
        ]);
    }


    /**
     * Store Data in DB
     * @param CheckFavorite $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CheckFavorite $request)
    {
        if($request->ajax()) {
            // Get Data course
            $course = Course::where('code' , $request->course_code)->firstOrFail();
            // Set course ID inside Data
            $data['course_id'] = $course->id;
            // Set User ID inside Dara
            $data['user_id'] = auth()->user()->id;
            // Store Data
            $save = $this->model->firstOrCreate($data);
            if ($save->wasRecentlyCreated) {
                $count = $this->model->where('user_id',auth()->user()->id)->count();
                return responseJson(true, __('lang.added_to_favorites_successfully'), ['count' => $count]);
            } else {

                return responseJson(false, __('lang.product_exist'));
            }
        }
        return responseJson(false);
    }


    /**
     * Delete course From Favourites List
     * @param CheckFavorite $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(CheckFavorite $request)
    {
        if($request->ajax()) {
            // Get course Data
            $data = $this->model->whereHas('course', function ($q) use ($request) {
                $q->where('code' ,$request->input('course_code'));
            })->where('user_id' ,auth()->user()->id)->firstOrFail();

            $data->delete();
            $count = $this->model->where('user_id' ,auth()->user()->id)->count();

            return responseJson(true, __('lang.deleted_from_favorites_successfully'),['count' => $count]);
        }
        return responseJson(false);
    }
}
