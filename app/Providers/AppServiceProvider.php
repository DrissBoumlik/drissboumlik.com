<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        \Str::macro('readDuration', function(...$text) {
            $totalWords = str_word_count(implode(" ", $text));
            $minutesToRead = round($totalWords / 200);

            return (int)max(1, $minutesToRead);
        });

        view()->composer('*', function ($view) {
            $mode = \Cookie::get('mode');
//            dump($mode);
            if ($mode != 'dark' && $mode != 'light') {
                $mode = 'dark';
            }
            $theme = \Cookie::get('theme');
//            dd($theme);
            if ($theme != 'dark-mode' && $theme != 'light-mode') {
                $theme = 'light-mode';
            }
            $view->with(['mode' => $mode, 'theme' => $theme]);
        });

        Paginator::useBootstrap();
    }
}
