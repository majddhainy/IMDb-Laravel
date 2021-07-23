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
Route::group([], function () {
    Route::get('/','CustomerController@home');
    Route::get('/home','CustomerController@home')->name('home');
    Route::get('movies','MovieController@get_movies')->name('get-movies');
    Route::post('movies','MovieController@search_movies')->name('search-movies');
    Route::get('movies/{id}','MovieController@show')->name('get-movie');
    Route::get('actors','ActorController@get_actors')->name('get-actors');
    Route::post('actors','ActorController@search_actors')->name('search-actors');
    Route::get('register','CustomerController@get_register')->name('get-register');
    Route::post('register','CustomerController@register')->name('register');
    Route::get('login','CustomerController@get_login')->name('get-login');
    Route::post('login','CustomerController@login')->name('login');
    Route::get('logout','CustomerController@logout')->name('logout');
    Route::get('forgot-password','CustomerController@get_forgot_password')->name('get-forgot-password');
    Route::post('forgot-password','CustomerController@forgot_password')->name('forgot-password');
    Route::get('/reset-password/{token}', 'CustomerController@get_reset_password')->name('get-reset-password');;
    Route::post('/reset-password', 'CustomerController@reset_password')->name('reset-password');
});


//private customer routes
//rate a movie

