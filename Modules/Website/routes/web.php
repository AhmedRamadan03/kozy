<?php

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

use Illuminate\Support\Facades\Auth;

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('front.login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('front.logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/verify', 'Auth\VerifyController@index')->name('verify');
Route::post('/verify', 'Auth\VerifyController@verify')->name('verify');


Route::get('/lang', 'LangController@index')->name('front.lang');

// Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('/login', 'Auth\LoginController@login');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('front.home');
Route::get('/update-session', 'HomeController@updateSession')->name('front.updateSession');
Route::get('/return-rules', 'HomeController@returnRules')->name('front.return-rules');
Route::get('/about-us', 'HomeController@aboutUs')->name('front.about-us');
Route::get('/contact-us', 'HomeController@contactUs')->name('front.contact-us');
Route::get('/categories', 'CategoryController@index')->name('front.categories');
Route::get('/products/{slug}', 'CategoryController@productDetails')->name('front.productDetails');
Route::get('/get-products-sizes', 'CategoryController@getProductsSizes')->name('front.get_product_sizes');

Route::middleware('auth')->group(function () {

Route::controller('CartController')->name('front.cart.')->prefix('carts')->group(function () {
    Route::get('/', 'index' )->name('cart')->middleware('auth');
    Route::post('/store', 'store')->name('store')->middleware('auth');
    Route::post('/update', 'update')->name('update')->middleware('auth');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy')->middleware('auth');
});


Route::controller('CheckoutController')->name('front.checkout.')->prefix('checkout')->group(function () {
    Route::get('/', 'index' )->name('index')->middleware('auth');
    Route::post('/store', 'store')->name('store')->middleware('auth');
    Route::post('/update', 'update')->name('update')->middleware('auth');
    Route::post('/get-cities', 'getCities')->name('get_cities')->middleware('auth');
});
Route::controller('ProfileController')->name('front.profile.')->prefix('profile')->group(function () {
    Route::get('/', 'index' )->name('index')->middleware('auth');
    Route::post('/update-profile', 'updateProfile' )->name('update-profile')->middleware('auth');
    Route::post('/update-password', 'updatePassword' )->name('change-password')->middleware('auth');
    Route::get('/my-orders', 'myOrders' )->name('my-orders')->middleware('auth');
    Route::delete('/orders/{ref}', 'cancelOrder' )->name('cancel-order')->middleware('auth');
});
Route::controller('FavController')->name('front.fav.')->prefix('profile/fav')->group(function () {
    Route::get('/', 'index' )->name('index')->middleware('auth');
    Route::post('/store', 'store' )->name('store')->middleware('auth');
    Route::post('/remove', 'remove' )->name('remove')->middleware('auth');
});
});
