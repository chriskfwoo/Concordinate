<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/scraping', 'HomeController@scraping');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', 'HomeController@index');

	Route::get('/user/profile', 'HomeController@profile');

	Route::get('/testing', 'HomeController@testing');
});

