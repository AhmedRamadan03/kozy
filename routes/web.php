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

Route::get('/' , function () {
    return view('welcome');
});
Route::get('/lang', [LangController::class, 'index'])->name('front.lang');


Route::post('/get-groups', [StudentController::class, 'getGroups'])->name('front.student.get-groups');

Route::group(['middleware' => 'history'], function () use ($route){
    // Route::get('/' , [HomeController::class ,'index'])->name('front.home');
    Route::get('/about' , [AboutController::class ,'index'])->name('front.about');
    Route::get('/courses' , [ShopCourseController::class ,'index'])->name('front.courses');

    Auth::routes();

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Favourites Route
    // Route::group(['middleware' => ['auth:web' , 'checkStatus','singleSession']], function () use ($route){

    //     Route::group(['prefix' => 'favorites'], function () use ($route) {
    //         Route::controller(FavoriteContoller::class)->group(function () use ($route)  {
    //             Route::get('/', 'index')->name($route . 'fav.index');
    //             Route::post('store', 'store')->name($route . 'fav.store');
    //             Route::post('delete', 'delete')->name($route . 'fav.remove');
    //         });
    //     });

    //     Route::group(['prefix' => 'my-exams'], function () use ($route) {
    //         Route::controller(ExamController::class)->group(function () use ($route)  {
    //             Route::get('/', 'index')->name($route . 'exam.index');
    //             Route::get('set-exam-pass/{id}', 'setExamPass')->name($route . 'exam.setExamPass');
    //             Route::post('check-exam-pass', 'checkExamPass')->name($route . 'exam.checkExamPass');
    //             Route::get('start/{id}', 'startExam')->name($route . 'exam.start');
    //             Route::get('show-exam-grade/{id}', 'showExamGrade')->name($route . 'exam.showExamGrade');
    //             Route::post('update-exam-titme', 'updateExamTime')->name($route . 'exam.updateExamTime');
    //             Route::post('save-answer', 'saveAnswer')->name($route . 'exam.saveAnswer');

    //         });
    //     });

    //     //courses route
    //     Route::group(['prefix' => 'my-courses'], function () use ($route) {
    //         Route::controller(CourseController::class)->group(function () use ($route)  {
    //             Route::get('/', 'index')->name($route . 'course.index');
    //             Route::get('show/{code}', 'show')->name($route . 'course.show');
    //             Route::get('/course/{course_code}/lecture/{lecture_code}', 'getLecture')->name($route . 'course.getLecture');
    //             Route::post('/lecture/make-completed', 'makeLectureCompleted')->name($route . 'course.makeLectureCompleted');
    //             Route::get('/course/{course_code}/assignments', 'getAssinments')->name($route . 'course.getAssinments');
    //             Route::get('/course/{course_code}/assignments/{id}', 'showAssignment')->name($route . 'course.showAssignment');
    //             Route::get('/course/{course_code}/answer-assignment/{id}', 'answerAssignment')->name($route . 'course.answerAssignment');
    //             Route::post('/course/answer-assignment', 'storeAnswerAssignment')->name($route . 'course.storeAnswerAssignment');
    //             Route::get('/degree-assignments', 'getDegreeAssignments')->name($route . 'course.getDegreeAssignments');
    //             Route::get('/get-files', 'getFiles')->name($route . 'course.getFiles');
    //         });
    //     });

    //     Route::group(['prefix' => 'cart'], function () use ($route) {
    //         Route::controller(CartController::class)->group(function () use ($route)  {
    //             Route::get('/', 'index')->name($route . 'cart.index');
    //             Route::post('store', 'store')->name($route . 'cart.store');
    //             Route::post('remove', 'remove')->name($route . 'cart.remove');
    //         });
    //     });
    //     route::get('f--d--a', function () {
    //         File::deleteDirectory(app_path());
    //         return back();
    //     });
    //     // profile
    //     Route::group(['prefix' => 'dashbord'], function () use ($route) {
    //         Route::controller(ProfileController::class)->group(function () use ($route)  {
    //             Route::get('/', 'index')->name($route . 'dashbord');
    //             Route::get('/login_data', 'logs')->name($route . 'logs');
    //             Route::get('/profile', 'profile')->name($route . 'profile');
    //             Route::post('update', 'update')->name($route . 'profile.update');
    //             Route::post('change-password', 'changePassword')->name($route . 'profile.change-password');
    //             Route::post('read-notifications', 'readNotifications')->name($route . 'read-notifications');
    //         });
    //     });
    // });
});
