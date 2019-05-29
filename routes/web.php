<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects','ProjectsController@index');
Route::post('/projects', 'ProjectsController@store')->middleware('auth');
Route::get('/project/{project}', 'ProjectsController@show');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
