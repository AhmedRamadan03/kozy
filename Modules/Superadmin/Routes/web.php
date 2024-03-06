<?php

use Modules\Superadmin\Http\Controllers\MainPageController;
use Modules\Superadmin\Http\Controllers\AdminController;
use Modules\Superadmin\Http\Controllers\BrandController;
use Modules\Superadmin\Http\Controllers\CategoryController;
use Modules\Superadmin\Http\Controllers\CityController;
use Modules\Superadmin\Http\Controllers\ColorController;
use Modules\Superadmin\Http\Controllers\CoponController;
use Modules\Superadmin\Http\Controllers\CountryController;
use Modules\Superadmin\Http\Controllers\ProductController;
use Modules\Superadmin\Http\Controllers\ReportController;
use Modules\Superadmin\Http\Controllers\RoleController;
use Modules\Superadmin\Http\Controllers\SettingController;
use Modules\Superadmin\Http\Controllers\SizeController;
use Modules\Superadmin\Http\Controllers\SubCategoryController;
use Modules\Superadmin\Http\Controllers\ToDoController;
use Modules\Superadmin\Http\Controllers\Website\AboutController;
use Modules\Superadmin\Http\Controllers\Website\FeatureController;
use Modules\Superadmin\Http\Controllers\Website\SliderController;

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

$prefix = 'admin.';

// Before Login Dashboard Routes
Route::group(['middleware' => 'guest:admin','prefix'=>'admin-panel'], function () use ($prefix) {
    $controller = 'AuthController@';
    // Route Login
    Route::get('login', $controller . 'view')->name($prefix . 'view_login');
    Route::post('login', $controller . 'login')->name($prefix . 'login');

});
Route::group(['middleware' => 'auth:admin','prefix'=>'admin-panel'],function() use ($prefix){

    Route::post('logout', 'AuthController@logout')->name($prefix . 'logout');
    Route::get('lang', 'LangController@changeLang')->name($prefix . 'lang');
    Route::get('/', 'SuperadminController@index')->name('admin.home');
    Route::get('/profile', 'SuperadminController@profile')->name('admin.profile');
    Route::post('/update-profile', 'SuperadminController@updateProfile')->name('admin.profile.update');




    //route of main page
    Route::group(['prefix' => 'global-settings'], function () use ($prefix) {
        Route::controller(MainPageController::class)->group(function () use ($prefix)  {
            Route::get('/', 'GlobalSettings')->name($prefix.'GlobalSettings');
            Route::get('/website-settings', 'websiteSettings')->name($prefix.'websiteSettings');
            Route::get('/security', 'security')->name($prefix.'security');
            Route::get('/products-categories', 'mainPageForProducts')->name($prefix.'mainPageForProducts');
            Route::get('/educations', 'mainPageForEducation')->name($prefix.'mainPageForEducation');
            Route::get('/questions-bank', 'QuestionsBank')->name($prefix.'QuestionsBank');

        });



        // route of copons
        Route::group(['prefix' => '/copons'], function () use ($prefix) {
            Route::controller(CoponController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'copon.index');
                Route::get('/create', 'create')->name($prefix.'copon.create');
                Route::post('/store', 'store')->name($prefix.'copon.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'copon.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'copon.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'copon.delete');
                Route::post('/change-status', 'changeStatus')->name($prefix.'copon.change-status');

            });
        });
        Route::group(['prefix' => '/reports'], function () use ($prefix) {
            Route::controller(ReportController::class)->group(function () use ($prefix)  {
                Route::get('/exam', 'examReport')->name($prefix.'report.exam');
                Route::get('/exam/export/', 'export')->name($prefix.'report.exam.export');

            });
        });

        // route of countries
        Route::group(['prefix' => '/countries'], function () use ($prefix) {
            Route::controller(CountryController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'country.index');
                Route::get('/create', 'create')->name($prefix.'country.create');
                Route::post('/store', 'store')->name($prefix.'country.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'country.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'country.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'country.delete');

            });
        });
        // route of cities
        Route::group(['prefix' => '/cities'], function () use ($prefix) {
            Route::controller(CityController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'city.index');
                Route::get('/create', 'create')->name($prefix.'city.create');
                Route::post('/store', 'store')->name($prefix.'city.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'city.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'city.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'city.delete');

            });
        });


        // route of settings
        Route::group(['prefix' => '/settings'], function () use ($prefix) {
            Route::controller(SettingController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'setting.index');
                Route::post('/update', 'update')->name($prefix.'setting.update');
            });
        });
    });





    // route of website settings
    Route::group(['prefix' => 'website-settings'], function () use ($prefix) {

        // route of sliders
        Route::group(['prefix' => '/sliders'], function () use ($prefix) {
            Route::controller(SliderController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'slider.index');
                Route::get('/create', 'create')->name($prefix.'slider.create');
                Route::post('/store', 'store')->name($prefix.'slider.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'slider.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'slider.update');
                Route::post('/change-status', 'changeStatus')->name($prefix.'slider.change-status');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'slider.delete');
            });
        });

        // route of features
        Route::group(['prefix' => '/features'], function () use ($prefix) {
            Route::controller(FeatureController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'feature.index');
                Route::get('/create', 'create')->name($prefix.'feature.create');
                Route::post('/store', 'store')->name($prefix.'feature.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'feature.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'feature.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'feature.delete');
            });
        });




        // route of about
        Route::group(['prefix' => '/about'], function () use ($prefix) {
            Route::controller(AboutController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'about.index');
                Route::post('/update', 'update')->name($prefix.'about.update');
            });
        });


    });



    // route of security
    Route::group(['prefix' => 'security'], function () use ($prefix) {

        // route of roles
        Route::group(['prefix' => '/roles'], function () use ($prefix) {
            Route::controller(RoleController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'role.index');
                Route::get('/create', 'create')->name($prefix.'role.create');
                Route::post('/store', 'store')->name($prefix.'role.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'role.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'role.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'role.delete');
            });
        });

        // route of admins
        Route::group(['prefix' => '/admins'], function () use ($prefix) {
            Route::controller(AdminController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'admin.index');
                Route::get('/create', 'create')->name($prefix.'admin.create');
                Route::post('/store', 'store')->name($prefix.'admin.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'admin.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'admin.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'admin.delete');
                Route::get('/auto-login/{id}', 'autoLogin')->name($prefix.'admin.auto-login');
            });
        });

    });


    // route of products-categories
    Route::group(['prefix' => 'products-categories'], function () use ($prefix) {

        // route of brands
        Route::group(['prefix' => '/brands'], function () use ($prefix) {
            Route::controller(BrandController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'brand.index');
                Route::get('/create', 'create')->name($prefix.'brand.create');
                Route::post('/store', 'store')->name($prefix.'brand.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'brand.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'brand.update');
                Route::post('/change-status', 'changeStatus')->name($prefix.'brand.change-status');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'brand.delete');
            });
        });

        // route of categories
        Route::group(['prefix' => '/categories'], function () use ($prefix) {
            Route::controller(CategoryController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'category.index');
                Route::get('/create', 'create')->name($prefix.'category.create');
                Route::post('/store', 'store')->name($prefix.'category.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'category.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'category.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'category.delete');
                Route::post('/change-status', 'changeStatus')->name($prefix.'category.change-status');

            });
        });

        // route of sup-categories
        Route::group(['prefix' => '/sup-categories'], function () use ($prefix) {
            Route::controller(SubCategoryController::class)->group(function () use ($prefix)  {
                Route::get('{id}/', 'index')->name($prefix.'subcat.index');
                Route::get('{id}/create', 'create')->name($prefix.'subcat.create');
                Route::post('/store', 'store')->name($prefix.'subcat.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'subcat.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'subcat.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'subcat.delete');
                Route::post('/change-status', 'changeStatus')->name($prefix.'subcat.change-status');

            });
        });


        // route of colors
        Route::group(['prefix' => '/colors'], function () use ($prefix) {
            Route::controller(ColorController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'color.index');
                Route::get('/create', 'create')->name($prefix.'color.create');
                Route::post('/store', 'store')->name($prefix.'color.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'color.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'color.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'color.delete');

            });
        });

        // route of sizes
        Route::group(['prefix' => '/sizes'], function () use ($prefix) {
            Route::controller(SizeController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'size.index');
                Route::get('/create', 'create')->name($prefix.'size.create');
                Route::post('/store', 'store')->name($prefix.'size.store');
                Route::get('/edit/{id}', 'edit')->name($prefix.'size.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'size.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'size.delete');

            });
        });

        // route of products
        Route::group(['prefix' => '/products'], function () use ($prefix) {
            Route::controller(ProductController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'product.index');
                Route::get('/create', 'create')->name($prefix.'product.create');
                Route::post('/store', 'store')->name($prefix.'product.store');
                Route::get('/show/{id}', 'show')->name($prefix.'product.show');
                Route::get('/edit/{id}', 'edit')->name($prefix.'product.edit');
                Route::post('/update/{id}', 'update')->name($prefix.'product.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'product.delete');
                Route::post('/change-status', 'changeStatus')->name($prefix.'product.change-status');
                Route::delete('{id}/delete-image/{it}', 'deleteImage')->name($prefix.'product.delete-image');
                Route::post('/get-brands-and-categories', 'getBrandsAndCategories')->name($prefix.'product.get-brands-and-categories');

            });
        });

        // route of orders
        Route::group(['prefix' => '/orders'], function () use ($prefix) {
            Route::controller(ProductController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'order.index');
                Route::post('/store', 'store')->name($prefix.'order.store');
                Route::get('/show/{id}', 'show')->name($prefix.'order.show');
                Route::post('/update/{id}', 'update')->name($prefix.'order.update');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'order.delete');

            });
        });

    });

     // route of todos
     Route::group(['prefix' => '/todos'], function () use ($prefix) {
        Route::controller(ToDoController::class)->group(function () use ($prefix)  {
            Route::get('/', 'index')->name($prefix.'todo.index');
            Route::get('/create', 'create')->name($prefix.'todo.create');
            Route::post('/store', 'store')->name($prefix.'todo.store');
            Route::get('/show/{id}', 'show')->name($prefix.'todo.show');
            Route::get('/edit/{id}', 'edit')->name($prefix.'todo.edit');
            Route::post('/update/{id}', 'update')->name($prefix.'todo.update');
            Route::delete('/delete/{id}', 'destroy')->name($prefix.'todo.delete');
            Route::post('/change-status', 'changeStatus')->name($prefix.'todo.change-status');

        });
    });


});
