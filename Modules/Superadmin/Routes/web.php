<?php

use Modules\Superadmin\Http\Controllers\MainPageController;
use Modules\Superadmin\Http\Controllers\AdminController;
use Modules\Superadmin\Http\Controllers\BrandController;
use Modules\Superadmin\Http\Controllers\CategoryController;
use Modules\Superadmin\Http\Controllers\CityController;
use Modules\Superadmin\Http\Controllers\ColorController;
use Modules\Superadmin\Http\Controllers\CoponController;
use Modules\Superadmin\Http\Controllers\CountryController;
use Modules\Superadmin\Http\Controllers\OfferController;
use Modules\Superadmin\Http\Controllers\OrderController;
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
            Route::get('/main-reports', 'PageOfReport')->name($prefix.'PageOfReport');

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


        // route of countries
        Route::group(['prefix' => '/countries'], function () use ($prefix) {
            Route::controller(CountryController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'country.index')->middleware('permission:admin_read-countries');
                Route::get('/create', 'create')->name($prefix.'country.create')->middleware('permission:admin_create-countries');
                Route::post('/store', 'store')->name($prefix.'country.store')->middleware('permission:admin_create-countries');
                Route::get('/edit/{id}', 'edit')->name($prefix.'country.edit')->middleware('permission:admin_update-countries');
                Route::post('/update/{id}', 'update')->name($prefix.'country.update')->middleware('permission:admin_update-countries');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'country.delete')->middleware('permission:admin_delete-countries');

            });
        });
        // route of cities
        Route::group(['prefix' => '/cities'], function () use ($prefix) {
            Route::controller(CityController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'city.index')->middleware('permission:admin_read-cities');
                Route::get('/create', 'create')->name($prefix.'city.create')->middleware('permission:admin_create-cities');
                Route::post('/store', 'store')->name($prefix.'city.store')->middleware('permission:admin_create-cities');
                Route::get('/edit/{id}', 'edit')->name($prefix.'city.edit')->middleware('permission:admin_update-cities');
                Route::post('/update/{id}', 'update')->name($prefix.'city.update')->middleware('permission:admin_update-cities');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'city.delete')->middleware('permission:admin_delete-cities');

            });
        });


        // route of settings
        Route::group(['prefix' => '/settings'], function () use ($prefix) {
            Route::controller(SettingController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'setting.index')->middleware('permission:admin_read-settings');
                Route::post('/update', 'update')->name($prefix.'setting.update')->middleware('permission:admin_update-settings');
            });
        });
    });

    Route::group(['prefix' => '/reports'], function () use ($prefix) {
        Route::controller(ReportController::class)->group(function () use ($prefix)  {
            Route::get('/orders', 'orders')->name($prefix.'report.orders')->middleware('permission:admin_read-orders');
            Route::get('/orders/export/', 'export')->name($prefix.'report.orders.export')->middleware('permission:admin_export-orders');
            Route::get('/statistics', 'statistics')->name($prefix.'report.statisticsReport')->middleware('permission:admin_read-orders_report');
            Route::get('/products-Report', 'productsReport')->name($prefix.'report.productsReport')->middleware('permission:admin_read-products_report');
            Route::get('/products-best-sales', 'trendingProducts')->name($prefix.'report.trendingProducts')->middleware('permission:admin_read-products_report');
            Route::get('/activity-logs', 'activityLogs')->name($prefix.'report.activityLogs')->middleware('permission:admin_read-activity_logs');

        });
    });




    // route of website settings
    Route::group(['prefix' => 'website-settings'], function () use ($prefix) {

        // route of sliders
        Route::group(['prefix' => '/sliders'], function () use ($prefix) {
            Route::controller(SliderController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'slider.index')->middleware('permission:admin_read-sliders');
                Route::get('/create', 'create')->name($prefix.'slider.create')->middleware('permission:admin_create-sliders');
                Route::post('/store', 'store')->name($prefix.'slider.store')->middleware('permission:admin_create-sliders');
                Route::get('/edit/{id}', 'edit')->name($prefix.'slider.edit')->middleware('permission:admin_update-sliders');
                Route::post('/update/{id}', 'update')->name($prefix.'slider.update')->middleware('permission:admin_update-sliders');
                Route::post('/change-status', 'changeStatus')->name($prefix.'slider.change-status')->middleware('permission:admin_update-sliders');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'slider.delete')->middleware('permission:admin_delete-sliders');
            });
        });

        // route of features
        Route::group(['prefix' => '/features'], function () use ($prefix) {
            Route::controller(FeatureController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'feature.index')->middleware('permission:admin_read-features');
                Route::get('/create', 'create')->name($prefix.'feature.create')->middleware('permission:admin_create-features');
                Route::post('/store', 'store')->name($prefix.'feature.store')->middleware('permission:admin_create-features');
                Route::get('/edit/{id}', 'edit')->name($prefix.'feature.edit')->middleware('permission:admin_update-features');
                Route::post('/update/{id}', 'update')->name($prefix.'feature.update')->middleware('permission:admin_update-features');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'feature.delete')->middleware('permission:admin_delete-features');
            });
        });




        // route of about
        Route::group(['prefix' => '/about'], function () use ($prefix) {
            Route::controller(AboutController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'about.index')->middleware('permission:admin_read-about-us');
                Route::post('/update', 'update')->name($prefix.'about.update')->middleware('permission:admin_update-about-us');
            });
        });


    });



    // route of security
    Route::group(['prefix' => 'security'], function () use ($prefix) {

        // route of roles
        Route::group(['prefix' => '/roles'], function () use ($prefix) {
            Route::controller(RoleController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'role.index')->middleware('permission:admin_read-roles');
                Route::get('/create', 'create')->name($prefix.'role.create')->middleware('permission:admin_create-roles');
                Route::post('/store', 'store')->name($prefix.'role.store')->middleware('permission:admin_create-roles');
                Route::get('/edit/{id}', 'edit')->name($prefix.'role.edit')->middleware('permission:admin_update-roles');
                Route::post('/update/{id}', 'update')->name($prefix.'role.update')->middleware('permission:admin_update-roles');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'role.delete')->middleware('permission:admin_delete-roles');
            });
        });

        // route of admins
        Route::group(['prefix' => '/admins'], function () use ($prefix) {
            Route::controller(AdminController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'admin.index')->middleware('permission:admin_read-admins');
                Route::get('/create', 'create')->name($prefix.'admin.create')->middleware('permission:admin_create-admins');
                Route::post('/store', 'store')->name($prefix.'admin.store')->middleware('permission:admin_create-admins');
                Route::get('/edit/{id}', 'edit')->name($prefix.'admin.edit')->middleware('permission:admin_update-admins');
                Route::post('/update/{id}', 'update')->name($prefix.'admin.update')->middleware('permission:admin_update-admins');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'admin.delete')->middleware('permission:admin_delete-admins');
                Route::get('/auto-login/{id}', 'autoLogin')->name($prefix.'admin.auto-login')->middleware('permission:admin_update-admins');
            });
        });

    });


    // route of products-categories
    Route::group(['prefix' => 'products-categories'], function () use ($prefix) {

        // route of brands
        Route::group(['prefix' => '/brands'], function () use ($prefix) {
            Route::controller(BrandController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'brand.index')->middleware('permission:admin_read-brands');
                Route::get('/create', 'create')->name($prefix.'brand.create')->middleware('permission:admin_create-brands');
                Route::post('/store', 'store')->name($prefix.'brand.store')->middleware('permission:admin_create-brands');
                Route::get('/edit/{id}', 'edit')->name($prefix.'brand.edit')->middleware('permission:admin_update-brands');
                Route::post('/update/{id}', 'update')->name($prefix.'brand.update')->middleware('permission:admin_update-brands');
                Route::post('/change-status', 'changeStatus')->name($prefix.'brand.change-status')->middleware('permission:admin_update-brands');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'brand.delete')->middleware('permission:admin_delete-brands');
            });
        });

        // route of categories
        Route::group(['prefix' => '/categories'], function () use ($prefix) {
            Route::controller(CategoryController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'category.index')->middleware('permission:admin_read-categories');
                Route::get('/create', 'create')->name($prefix.'category.create')->middleware('permission:admin_create-categories');
                Route::post('/store', 'store')->name($prefix.'category.store')->middleware('permission:admin_create-categories');
                Route::get('/edit/{id}', 'edit')->name($prefix.'category.edit')->middleware('permission:admin_update-categories');
                Route::post('/update/{id}', 'update')->name($prefix.'category.update')->middleware('permission:admin_update-categories');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'category.delete')->middleware('permission:admin_delete-categories');
                Route::post('/change-status', 'changeStatus')->name($prefix.'category.change-status')->middleware('permission:admin_update-categories');

            });
        });

        // route of sup-categories
        Route::group(['prefix' => '/sup-categories'], function () use ($prefix) {
            Route::controller(SubCategoryController::class)->group(function () use ($prefix)  {
                Route::get('{id}/', 'index')->name($prefix.'subcat.index')->middleware('permission:admin_read-sub_categories');
                Route::get('{id}/create', 'create')->name($prefix.'subcat.create')->middleware('permission:admin_create-sub_categories');
                Route::post('/store', 'store')->name($prefix.'subcat.store')->middleware('permission:admin_create-sub_categories');
                Route::get('/edit/{id}', 'edit')->name($prefix.'subcat.edit')->middleware('permission:admin_update-sub_categories');
                Route::post('/update/{id}', 'update')->name($prefix.'subcat.update')->middleware('permission:admin_update-sub_categories');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'subcat.delete')->middleware('permission:admin_delete-sub_categories');
                Route::post('/change-status', 'changeStatus')->name($prefix.'subcat.change-status')->middleware('permission:admin_update-sub_categories');

            });
        });


        // route of colors
        Route::group(['prefix' => '/colors'], function () use ($prefix) {
            Route::controller(ColorController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'color.index')->middleware('permission:admin_read-colors');
                Route::get('/create', 'create')->name($prefix.'color.create')->middleware('permission:admin_create-colors');
                Route::post('/store', 'store')->name($prefix.'color.store')->middleware('permission:admin_create-colors');
                Route::get('/edit/{id}', 'edit')->name($prefix.'color.edit')->middleware('permission:admin_update-colors');
                Route::post('/update/{id}', 'update')->name($prefix.'color.update')->middleware('permission:admin_update-colors');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'color.delete')->middleware('permission:admin_delete-colors');

            });
        });

        // route of sizes
        Route::group(['prefix' => '/sizes'], function () use ($prefix) {
            Route::controller(SizeController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'size.index')->middleware('permission:admin_read-sizes');
                Route::get('/create', 'create')->name($prefix.'size.create')->middleware('permission:admin_create-sizes');
                Route::post('/store', 'store')->name($prefix.'size.store')->middleware('permission:admin_create-sizes');
                Route::get('/edit/{id}', 'edit')->name($prefix.'size.edit')->middleware('permission:admin_update-sizes');
                Route::post('/update/{id}', 'update')->name($prefix.'size.update')->middleware('permission:admin_update-sizes');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'size.delete')->middleware('permission:admin_delete-sizes');

            });
        });


        // route of offers
        Route::group(['prefix' => '/offers'], function () use ($prefix) {
            Route::controller(OfferController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'offer.index')->middleware('permission:admin_read-offers');
                Route::get('/create', 'create')->name($prefix.'offer.create')->middleware('permission:admin_create-offers');
                Route::post('/store', 'store')->name($prefix.'offer.store')->middleware('permission:admin_create-offers');
                Route::get('/edit/{id}', 'edit')->name($prefix.'offer.edit')->middleware('permission:admin_update-offers');
                Route::post('/update/{id}', 'update')->name($prefix.'offer.update')->middleware('permission:admin_update-offers');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'offer.delete')->middleware('permission:admin_delete-offers');
                Route::get('searchProduct', 'searchProduct')->name($prefix.'offer.searchProduct');


            });
        });

        // route of products
        Route::group(['prefix' => '/products'], function () use ($prefix) {
            Route::controller(ProductController::class)->group(function () use ($prefix)  {
                Route::get('/', 'index')->name($prefix.'product.index')->middleware('permission:admin_read-products');
                Route::get('/create', 'create')->name($prefix.'product.create')->middleware('permission:admin_create-products');
                Route::post('/store', 'store')->name($prefix.'product.store')->middleware('permission:admin_create-products');
                Route::get('/show/{id}', 'show')->name($prefix.'product.show')->middleware('permission:admin_read-products');
                Route::get('/edit/{id}', 'edit')->name($prefix.'product.edit')->middleware('permission:admin_update-products');
                Route::post('/update/{id}', 'update')->name($prefix.'product.update')->middleware('permission:admin_update-products');
                Route::delete('/delete/{id}', 'destroy')->name($prefix.'product.delete')->middleware('permission:admin_delete-products');
                Route::post('/change-status', 'changeStatus')->name($prefix.'product.change-status')->middleware('permission:admin_update-products');
                Route::delete('{id}/delete-image/{it}', 'deleteImage')->name($prefix.'product.delete-image')->middleware('permission:admin_update-products');
                Route::post('/get-brands-and-categories', 'getBrandsAndCategories')->name($prefix.'product.get-brands-and-categories');

            });
        });


    });
    // route of orders
    Route::group(['prefix' => '/orders'], function () use ($prefix) {
        Route::controller(OrderController::class)->group(function () use ($prefix)  {
            Route::get('/', 'index')->name($prefix.'order.index')->middleware('permission:admin_read-orders');
            Route::get('/show/{id}', 'show')->name($prefix.'order.show')->middleware('permission:admin_read-orders');
            Route::get('/pdfview/{id}', 'pdfview')->name($prefix.'order.pdfview')->middleware('permission:admin_read-orders');
            Route::get('/getNotesModal/{id}', 'getNotesModal')->name($prefix.'order.admin-notes')->middleware('permission:admin_update-orders');
            Route::post('/save-notes', 'saveAdminNotes')->name($prefix.'order.saveAdminNotes')->middleware('permission:admin_update-orders');
            Route::post('/status/{id}', 'status')->name($prefix.'order.status')->middleware('permission:admin_update-orders');
            Route::post('/update/{id}', 'update')->name($prefix.'order.update')->middleware('permission:admin_update-orders');
            Route::delete('/delete/{id}', 'destroy')->name($prefix.'order.delete');

        });
    });

     // route of todos
     Route::group(['prefix' => '/todos'], function () use ($prefix) {
        Route::controller(ToDoController::class)->group(function () use ($prefix)  {
            Route::get('/', 'index')->name($prefix.'todo.index')->middleware('permission:admin_read-todos');
            Route::get('/create', 'create')->name($prefix.'todo.create')->middleware('permission:admin_create-todos');
            Route::post('/store', 'store')->name($prefix.'todo.store')->middleware('permission:admin_create-todos');
            Route::get('/getNotesModal/{id}', 'getNotesModal')->name($prefix.'todo.notes')->middleware('permission:admin_update-todos');
            Route::post('/save-notes', 'saveNotes')->name($prefix.'todo.saveNotes')->middleware('permission:admin_update-todos');
            Route::get('/show/{id}', 'show')->name($prefix.'todo.show')->middleware('permission:admin_read-todos');
            Route::get('/edit/{id}', 'edit')->name($prefix.'todo.edit')->middleware('permission:admin_update-todos');
            Route::post('/update/{id}', 'update')->name($prefix.'todo.update')->middleware('permission:admin_update-todos');
            Route::delete('/delete/{id}', 'destroy')->name($prefix.'todo.delete')->middleware('permission:admin_delete-todos');
            Route::post('/change-status', 'changeStatus')->name($prefix.'todo.change-status')->middleware('permission:admin_update-todos');

        });
    });


});
