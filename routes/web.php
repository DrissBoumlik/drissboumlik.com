<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('cache.headers:public;max_age=15811200;etag')->group(function () {

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });


    Route::get('/category/{category}', 'PostController@getPostsByCategory');
    Route::get('/tags/{tag}', 'PostController@getPostsByTag');
    Route::get('blog', 'PostController@index');
    Route::get('blog/{slug}', 'PostController@show');


     // SiteMap
    Route::get('/sitemap', 'SitemapController@sitemap');
    Route::get('/generateSitemap', 'SitemapController@generateSitemap');

    // External
    Route::get('/social/{link}', 'GotoController@gotoExternalLink');

    Route::redirect('/', '/resume');
    // Resume
    Route::get('resume', 'PageController@resume');

    Route::any('/{var}', 'HomeController@home')->where('var', '.*');
});
