<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

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
        Carbon::setLocale('id');
        // Component of Admin LTE
        Blade::component('alert', 'Alert');
        Blade::component('content-header', 'ContentHeader');
        Blade::component('crud', 'Crud');
        Blade::component('data-table', 'DataTable');
        Blade::component('import-button', 'ImportButton');
        Blade::component('import-modal', 'ImportModal');
    }
}
