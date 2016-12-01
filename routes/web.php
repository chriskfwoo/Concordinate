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

	Route::get('/schedule', 'HomeController@viewScheduleView');

	Route::post('/schedule/delete', 'HomeController@deleteSchedule');
	

	Route::get('/', 'GenerateScheduleController@schedulerView');

	Route::get('/scheduler/generate', 'GenerateScheduleController@getPossibleSchedules');


	Route::get('/completed', 'HomeController@completedCoursesView');

	Route::get('/user/profile', 'HomeController@profile');

	Route::get('/generated/schedules/{combinations}', 'GenerateScheduleController@generatedSchedulesView');

	Route::post('/generated/schedules/save', [
		'as' => 'saveSchedule',
		'uses' => 'GenerateScheduleController@saveSchedule'
	]);

	Route::get('/generated/schedules/save/confirm', [
		'as' => 'confirmSchedule',
		'uses' => 'GenerateScheduleController@continueScheduleView'
	]);

	Route::get('/testing', 'HomeController@testing');
	
	Route::get('/getCombinations', 'SchedulingMethods@getCombinations');

	Route::post('/courses/completed/save', 'HomeController@saveCompletedCourses');
});

