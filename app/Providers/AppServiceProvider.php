<?php

namespace App\Providers;

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
        view()->composer('*', function ($view) {
            $mode = \Cookie::get('mode');
            if ($mode != 'dark' && $mode != 'light') {
                $mode = 'light';
            }
            $view->with('mode', $mode);
        });
    }
}
