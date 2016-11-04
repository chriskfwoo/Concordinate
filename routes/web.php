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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', 'HomeController@homeView');

	Route::get('/scheduler', 'GenerateScheduleController@schedulerView');

	Route::get('/scheduler/generate', 'GenerateScheduleController@getPossibleSchedules');

	Route::get('/schedule', 'HomeController@viewScheduleView');

	Route::get('/completed', 'HomeController@completedCoursesView');

	Route::get('/user/profile', 'HomeController@profile');

	Route::get('/testing', 'HomeController@testing');


	Route::get('/scraping', 'HomeController@scraping');
	
	Route::get('/getCombinations', 'SchedulingMethods@getCombinations');

	Route::post('/courses/completed/save', 'HomeController@saveCompletedCourses');
});

