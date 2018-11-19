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

Route::get('/', 'studentController@index');
Route::post('/create', 'studentController@create');
Route::get('/show', 'studentController@show');
Route::delete('/delete/{id}', 'studentController@delete');
Route::get('/profile/{id}', 'studentController@profile');
Route::post('/find-student/{id}', 'studentController@findStudent');
Route::put('/update/{id}', 'studentController@update');