<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects','ProjectsController@index');
    Route::post('/projects', 'ProjectsController@store');
    Route::get('/project/{project}', 'ProjectsController@show');    
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
