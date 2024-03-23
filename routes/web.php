<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ShopCourseController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CourseController;
use App\Http\Controllers\Website\ExamController;
use App\Http\Controllers\Website\FavoriteContoller;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\LangController;
use App\Http\Controllers\Website\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\Superadmin\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$route = 'front.';

Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache Cleared";
});

Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    return "migrate-fresh";

});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return "migrate done";

});
Route::get('/seed', function () {
    Artisan::call('db:seed');
    return "seeder done";

});

// Route::get('/' , function () {
//     return view('welcome');
// });

