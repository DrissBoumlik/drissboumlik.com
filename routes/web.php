<?php

// use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ToolController;

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
            // Auth
            Route::post('/logout', [LoginController::class , 'logout'])->name('logout');
            // Profile
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
            // Tools
            // Route::get('/export-db', [ToolController::class , 'export_db']);

            // Blog
            Route::get('/posts', [PostController::class, 'index']);
            Route::get('/posts/create', [PostController::class, 'create']);
            Route::post('/posts', [PostController::class, 'store']);
            Route::get('/posts/edit/{slug}', [PostController::class, 'edit']);
            Route::put('/posts/{slug}', [PostController::class, 'update']);
            Route::post('/api/posts', [PostController::class, 'api_store']); // Testing cropper js

            Route::get('/tags', [TagController::class, 'index']);
            Route::get('/tags/create', [TagController::class, 'create']);
            Route::get('/tags/edit/{slug}', [TagController::class, 'edit']);
            Route::put('/tags/{slug}', [TagController::class, 'update']);
            Route::post('/tags', [TagController::class, 'store']);
        });
    });

    Route::post('/subscribers', [SubscriberController::class, 'subscribe']);
    Route::get('/blog/tags', [BlogController::class, 'tagsList']);
    Route::get('/blog/tags/{slug}', [BlogController::class, 'getPostsBytag']);
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog/{slug}', [BlogController::class, 'show']);
    Route::post('/blog/like/{slug}', [BlogController::class, 'likePost']);
    // Route::get('blog/{slug}', [PostController::class, 'show']);

    // Route::get('/tags/{tag}', [PostController::class, 'getPostsByTag']);


     // SiteMap
    Route::get('/sitemap', [SitemapController::class, 'sitemap']);
    Route::get('/generateSitemap', [SitemapController::class, 'generateSitemap']);

    Route::redirect('/', '/admin/posts');
    // Resume
    Route::get('resume', [PageController::class, 'resume']);

    // External
    // Route::get('/{link}', [GotoController::class, 'goto']);

    // Route::any('/{var}', [HomeController::class, 'home'])->where('var', '.*');
});
