<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = Setting::select('id','site_name','site_title','header_logo','footer_logo','fav_icon','contact_number','email','address','fax')->first();
        view()->share('setting', $setting);
    }
}
