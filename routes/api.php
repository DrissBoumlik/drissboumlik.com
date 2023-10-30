<?php

use App\Http\Controllers\Admin\Api\PostController;
use App\Http\Controllers\Admin\Api\TagController;
use App\Http\Controllers\Admin\Api\VisitorController;
use App\Http\Controllers\Admin\Api\MessageController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/posts', [PostController::class, 'index']);
Route::post('/tags', [TagController::class, 'index']);
Route::post('/visitors', [VisitorController::class, 'index']);
Route::post('/messages', [MessageController::class, 'index']);

Route::post('/get-in-touch', [ContactController::class, 'getInTouch']);
