<?php

use App\Http\Controllers\GotoController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PageController as AdminPageController ;
use App\Http\Controllers\Admin\ToolController as AdminToolController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Api\PostController as ApiPostController;
use App\Http\Controllers\Admin\Api\TagController as ApiTagController;
use App\Http\Controllers\Admin\Api\DatatableController as AdminDatatableController;
use App\Http\Controllers\Admin\Api\CRUDController as AdminCRUDController;
use App\Http\Controllers\Admin\Api\PortfolioController as AdminApiPortfolioController;
use App\Http\Controllers\Admin\Api\MenuController as AdminApiMenuController;
use App\Http\Controllers\Api\ContactController;

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
            Route::post('/visitors', [AdminDatatableController::class, 'visitors']);
            Route::put('/visitors/{visitor}', [AdminCRUDController::class, 'updateVisitor']);
            Route::put('/testimonials/{testimonial}', [AdminApiPortfolioController::class, 'updateTestimonial']);
            Route::post('/testimonials', [AdminApiPortfolioController::class, 'storeTestimonial']);
            Route::put('/projects/{project}', [AdminApiPortfolioController::class, 'updateProject']);
            Route::post('/projects', [AdminApiPortfolioController::class, 'storeProject']);
            Route::put('/services/{service}', [AdminApiPortfolioController::class, 'updateService']);
            Route::post('/services', [AdminApiPortfolioController::class, 'storeService']);
            Route::put('/shortened-urls/{shortenedUrl}', [AdminCRUDController::class, 'updateShortenedUrl']);
            Route::post('/shortened-urls', [AdminCRUDController::class, 'storeShortenedUrl']);
            Route::put('/menus/{menu}', [AdminApiMenuController::class, 'updateMenu']);
            Route::post('/menus', [AdminApiMenuController::class, 'storeMenu']);
            Route::put('/menu-types/{menuType}', [AdminCRUDController::class, 'updateMenuType']);
            Route::post('/messages', [AdminDatatableController::class, 'messages']);
            Route::post('/subscriptions', [AdminDatatableController::class, 'subscriptions']);
            Route::post('/testimonials/list', [AdminDatatableController::class, 'testimonials']);
            Route::post('/projects/list', [AdminDatatableController::class, 'projects']);
            Route::post('/services/list', [AdminDatatableController::class, 'services']);
            Route::post('/menus/list', [AdminDatatableController::class, 'menus']);
            Route::post('/shortened-urls/list', [AdminDatatableController::class, 'shortenedUrls']);
            Route::post('/menu-types', [AdminDatatableController::class, 'menuTypes']);
            Route::get('/posts/{slug}/assets', [ApiPostController::class, 'getPostAssets']);
            Route::get('/{table}/columns', [AdminToolController::class, 'getTableColumns']);
            Route::post('/stats', [AdminToolController::class, 'getTableColumnStats']);
            Route::post('/file', [FileManagerController::class, 'uploadFile']);
            Route::post('/file/copy', [FileManagerController::class, 'copyFile']);
            Route::post('/file/rename', [FileManagerController::class, 'renameFile']);
            Route::get('/files/{path?}', [FileManagerController::class, 'getFiles'])->where('path', '.*');
            Route::delete('/path/{path}/name/{name}', [FileManagerController::class, 'deleteFile'])->where('path', '.*');
            Route::post('/directories', [FileManagerController::class, 'createDirectories']);
            Route::delete('/directories/{path}', [FileManagerController::class, 'emptyDirectory'])->where('path', '.*');
        });
        Route::post('/get-in-touch', [ContactController::class, 'getInTouch']);
//        Route::post('/blog/{slug}/{value}', [BlogController::class, 'likePost']);
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
            // Auth
            Route::post('/logout', [LoginController::class , 'logout'])->name('logout');
            // Profile
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
            // Blog
            Route::get('/posts', [PostController::class, 'index']);
            Route::get('/posts/create', [PostController::class, 'create']);
            Route::post('/posts', [PostController::class, 'store']);
            Route::get('/posts/edit/{slug}', [PostController::class, 'edit']);
            Route::put('/posts/{slug}', [PostController::class, 'update']);
            Route::get('/tags', [TagController::class, 'index']);
            Route::get('/tags/create', [TagController::class, 'create']);
            Route::get('/tags/edit/{slug}', [TagController::class, 'edit']);
            Route::put('/tags/{slug}', [TagController::class, 'update']);
            Route::post('/tags', [TagController::class, 'store']);

            Route::get('/messages', [AdminPageController::class, 'messages']);
            Route::get('/subscriptions', [AdminPageController::class, 'subscriptions']);
            Route::get('/testimonials', [AdminPageController::class, 'testimonials']);
            Route::get('/projects', [AdminPageController::class, 'projects']);
            Route::get('/services', [AdminPageController::class, 'services']);
            Route::get('/shortened-urls', [AdminPageController::class, 'shortenedUrls']);
            Route::get('/menus', [AdminPageController::class, 'menus']);
            Route::get('/menu-types', [AdminPageController::class, 'menuTypes']);

            Route::get('/visitors', [AdminPageController::class, 'visitors']);
            Route::get('/visitors/charts', [AdminPageController::class, 'visitorsCharts']);

            // Tools
            Route::get('/sitemap', [AdminPageController::class, 'sitemap']);
            Route::get('/generate-sitemap', [AdminToolController::class, 'generateSitemap']);
            Route::get('/export-db/config', [AdminToolController::class , 'exportDbConfig']);
            Route::get('/export-db', [AdminToolController::class , 'export_db']);

            Route::get('file-manager/{path?}', [FileManagerController::class, 'index'])->where('path', '.*');
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
        Route::get('/search', [BlogController::class, 'search']);

        Route::get('/sitemap', [SitemapController::class, 'sitemap']);
        Route::get('/', [PageController::class, 'home']);
        Route::get('about', [PageController::class, 'about']);
        Route::get('resume', [PageController::class, 'resume']);
        Route::get('testimonials', [PageController::class, 'testimonials']);
        Route::get('work', [PageController::class, 'projects']);
        Route::get('contact', [PageController::class, 'contact']);
        Route::get('services', [PageController::class, 'services']);
        Route::get('privacy-policy', [PageController::class, 'privacyPolicy']);

        Route::get('pixel', [ToolController::class, 'getPixel']);
        Route::feeds();
        // External
        Route::get('/not-found', [GotoController::class, 'not_found']);
        Route::get('/{link}', [GotoController::class, 'goto']);

        Route::any('/{var}', [GotoController::class, 'not_found'])->where('var', '.*');
    });

});
