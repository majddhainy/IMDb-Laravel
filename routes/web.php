<?php

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


use App\Http\Controllers\ActorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

//public cms routes
Route::group(['prefix' => 'cms'], function () {
Route::get('login','AdminController@get_login')->name('get-cms-login');
Route::post('login','AdminController@login')->name('cms-login');
Route::get('forgot-password','AdminController@get_forgot_password')->name('get-cms-forgot-password');
Route::post('forgot-password','AdminController@forgot_password')->name('cms-forgot-password');
Route::get('/reset-password/{token}', 'AdminController@get_reset_password')->name('get-cms-reset-password');;
Route::post('/reset-password', 'AdminController@reset_password')->name('cms-reset-password');
});


//private cms routes
Route::group(['prefix' => 'cms' , 'middleware' => ['AdminAuth']], function () {
    Route::get('home','AdminController@home')->name('cms-home');
    Route::resource('movies', 'MovieController');
    Route::resource('categories','CategoryController' );
    Route::resource('actors', 'ActorController');
    Route::get('logout','AdminController@logout')->name('cms-logout');
});

//public customer routes


//private customer routes

