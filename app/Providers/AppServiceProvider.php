<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Country;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PaginationPaginator::useBootstrap();
        session()->put('locale', 'ar');

        if (Schema::hasTable('settings')) {
            $settings = Setting::all();
            view()->share('settings', $settings);
            $countries = Country::get()->pluck('title' , 'id');
            view()->share('countries', $countries);

            // Get Countries For Header
            $countrieH = Country::get();
            view()->share('countrieH', $countrieH);

            //count of Order where show 0
            view()->share('orders_count', DB::table('orders')->where('show', 0)->count());

            session()->put('country',Country::first());

        }
    }
}
