<?php

// use App\Http\Controllers\AdminController;
use App\Http\Controllers\GotoController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\SitemapController as AdminSitemapController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ToolController;
//use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Api\PostController as ApiPostController;
use App\Http\Controllers\Admin\Api\TagController as ApiTagController;
use App\Http\Controllers\Admin\Api\VisitorController as ApiVisitorController;
use App\Http\Controllers\Admin\Api\MessageController as ApiMessageController;
use App\Http\Controllers\Admin\Api\SubscriberController as AdminApiSubscriberController;
use App\Http\Controllers\Api\ContactController;
//use App\Http\Controllers\Api\SubscriberController as ApiSubscriberController;
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

Route::middleware(['cache.headers:public;max_age=15811200;etag'])->group(function () {

    Route::group(['prefix' => 'api'], function () {
        Route::middleware('auth')->group(function () {
            Route::post('/posts', [ApiPostController::class, 'index']);
            Route::post('/tags', [ApiTagController::class, 'index']);
            Route::post('/visitors', [ApiVisitorController::class, 'index']);
            Route::put('/visitors/{visitor}', [ApiVisitorController::class, 'update']);
            Route::post('/messages', [ApiMessageController::class, 'index']);
            Route::post('/subscriptions', [AdminApiSubscriberController::class, 'index']);
            Route::get('/posts/{slug}/assets', [ApiPostController::class, 'getPostAssets']);
            Route::get('/{table}/columns', [ToolController::class, 'getTableColumns']);
            Route::post('/stats', [ToolController::class, 'getTableColumnStats']);
            Route::post('/media', [FileManagerController::class, 'uploadMedia']);
            Route::post('/media/copy', [FileManagerController::class, 'copyMedia']);
            Route::post('/media/rename', [FileManagerController::class, 'renameMedia']);
            Route::get('/medias/{path?}', [FileManagerController::class, 'getMedias'])->where('path', '.*');
            Route::delete('/path/{path}/name/{name}', [FileManagerController::class, 'deleteMedia'])->where('path', '.*');
            Route::post('/directories', [FileManagerController::class, 'createDirectories']);
            Route::delete('/directories/{path}', [FileManagerController::class, 'emptyDirectory'])->where('path', '.*');
        });
        Route::post('/get-in-touch', [ContactController::class, 'getInTouch']);
        Route::post('/blog/{slug}/{value}', [BlogController::class, 'likePost']);
//        Route::post('/subscribers', [ApiSubscriberController::class, 'subscribe']);
//        Route::put('/subscribers/{uuid}', [ApiSubscriberController::class, 'update']);
    });

    Route::prefix('admin')->group(function () {

        Route::redirect('/', '/admin/posts');
        Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class , 'login']);

        Route::get('/password/reset', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/email', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [ResetPasswordController::class , 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [ResetPasswordController::class , 'reset'])->name('password.update');


        Route::middleware('auth')->group(function () {
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
//            Route::post('/api/posts', [PostController::class, 'api_store']); // Testing cropper js

            Route::get('/tags', [TagController::class, 'index']);
            Route::get('/tags/create', [TagController::class, 'create']);
            Route::get('/tags/edit/{slug}', [TagController::class, 'edit']);
            Route::put('/tags/{slug}', [TagController::class, 'update']);
            Route::post('/tags', [TagController::class, 'store']);

            Route::get('/messages', [MessageController::class, 'index']);
            Route::get('/subscriptions', [AdminSubscriberController::class, 'index']);

            Route::get('/visitors', [VisitorController::class, 'index']);
            Route::get('/visitors/charts', [VisitorController::class, 'charts']);

            Route::get('/sitemap', [AdminSitemapController::class, 'index']);
            Route::get('/generate-sitemap', [AdminSitemapController::class, 'generateSitemap']);
            Route::get('/export-db/config', [ToolController::class , 'exportDbConfig']);
            Route::get('/export-db', [ToolController::class , 'export_db']);

            Route::get('media-manager/{path?}', [FileManagerController::class, 'index'])->where('path', '.*');
        });
    });

    Route::middleware('location')->group(function () {
//        Route::get('/subscribers/{uuid}', [SubscriberController::class, 'show']);
//        Route::get('/subscribers/verify/{token}', [SubscriberController::class, 'verifySubscribtion']);
        Route::get('/tags', [BlogController::class, 'getTags']);
        Route::get('/tags/{slug}', [BlogController::class, 'getPostsBytag']);
        Route::get('/blog', [BlogController::class, 'getPosts']);
        Route::get('/blog/{slug}', [BlogController::class, 'getPost']);
    //    Route::post('/blog/like/{slug}/{unlike?}', [BlogController::class, 'likePost']);
        // Route::get('blog/{slug}', [PostController::class, 'show']);

        // Route::get('/tags/{tag}', [PostController::class, 'getPostsByTag']);

        // Search Blog
        Route::get('/search', [BlogController::class, 'search']);

        // SiteMap
        Route::get('/sitemap', [SitemapController::class, 'sitemap']);

    //    Route::redirect('/', '/resume');
        Route::get('/', [PageController::class, 'home']);
        // About
        Route::get('about', [PageController::class, 'about']);
        // Resume
        Route::get('resume', [PageController::class, 'resume']);
        // Testimonials
        Route::get('testimonials', [PageController::class, 'testimonials']);
        // Work
        Route::get('work', [PageController::class, 'work']);
        // Contact
        Route::get('contact', [PageController::class, 'contact']);
        // Services
        Route::get('services', [PageController::class, 'services']);
        // Privacy policy
        Route::get('privacy-policy', [PageController::class, 'privacyPolicy']);

        Route::get('pixel', [ToolController::class, 'getPixel']);
        Route::feeds();
        // External
        Route::get('/not-found', [GotoController::class, 'not_found']);
        Route::get('/{link}', [GotoController::class, 'goto']);

        Route::any('/{var}', [GotoController::class, 'not_found'])->where('var', '.*');
    });

});
