<?php

// use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GotoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
// use App\Http\Controllers\ToolController;
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

// Route::middleware('cache.headers:public;max_age=15811200;etag')->group(function () {
Route::group([], function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::redirect('/', 'admin/posts');
        Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class , 'login']);

        Route::get('/password/reset', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/email', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [ResetPasswordController::class , 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [ResetPasswordController::class , 'reset'])->name('password.update');


        Route::group(['middleware' => 'auth'], function() {
            // Profile
            // Route::get('profile', [AdminController::class, 'profile'])->name('profile');
            // Route::post('profile', [AdminController::class, 'updateProfile'])->name('profile.update');
            // Blog
            Route::get('blog/create', [PostController::class, 'create']);
            // Auth
            Route::post('/logout', [LoginController::class , 'logout'])->name('logout');
            // Tools
            // Route::get('/export-db', [ToolController::class , 'export_db']);

            Route::get('/posts', 'PostController@index');
            Route::get('/posts/create', 'PostController@create');
            Route::post('/posts', 'PostController@store');
            Route::get('/posts/edit/{slug}', 'PostController@edit');
            Route::put('/posts/{slug}', 'PostController@update');
        });
    });

    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{slug}', 'BlogController@show');
    // Route::get('blog/{slug}', [PostController::class, 'show']);

    // Route::get('/tags/{tag}', [PostController::class, 'getPostsByTag']);


     // SiteMap
    Route::get('/sitemap', [SitemapController::class, 'sitemap']);
    Route::get('/generateSitemap', [SitemapController::class, 'generateSitemap']);

    Route::redirect('/', '/resume');
    // Resume
    Route::get('resume', [PageController::class, 'resume']);

    // External
    // Route::get('/{link}', [GotoController::class, 'goto']);

    // Route::any('/{var}', [HomeController::class, 'home'])->where('var', '.*');
});
