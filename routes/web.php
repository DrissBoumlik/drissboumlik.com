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

Route::get('/cv/{lang?}', 'PageController@getCV');
Route::get('/{lang?}', 'PageController@resume');

// External
Route::get('/social/{link}', 'GotoController@gotoExternalLink');
