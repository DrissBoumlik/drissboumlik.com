<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{

    private $appInProduction = false;

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

        $this->appInProduction = $this->app->isProduction();

        $this->configureModel();

		$this->registerMacros();

        $this->viewSetup();

        $this->alterPaths();
    }

    private function alterPaths()
    {
        $base_path = base_path();
        if(file_exists(str_ends_with($base_path, 'base'))) {
            $this->app->useStoragePath( realpath($base_path . '/..') . '/storage');
            $this->app->usePublicPath($base_path . '/..');
        }
    }

    private function configureModel()
    {
        Model::shouldBestrict(! $this->appInProduction);
    }

    private function viewSetup()
    {
        \Vite::useScriptTagAttributes([ 'defer' => true, ]);

        view()->composer('*', function ($view) {
            $mode = \Cookie::get('mode');
            if ($mode != 'dark' && $mode != 'light') {
                $mode = 'dark';
            }
            $theme = \Cookie::get('theme');
            if ($theme != 'dark-mode' && $theme != 'light-mode') {
                $theme = 'dark-mode';
            }
            $view->with(['mode' => $mode, 'theme' => $theme]);
        });

        Paginator::useBootstrap();
    }

	private function registerMacros()
	{
		\Str::macro('readDuration', function(...$text) {
            $totalWords = str_word_count(implode(" ", $text));
            $minutesToRead = round($totalWords / 200);

            return (int)max(1, $minutesToRead);
        });
	}
}
