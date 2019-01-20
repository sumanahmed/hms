<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'doctor'], function () {
    Route::get('/index','DoctorController@index')->name('doctor_index');
    Route::get('/create','DoctorController@create')->name('doctor_create');
    Route::post('/store','DoctorController@store')->name('doctor_store');
    Route::get('/edit/{id}','DoctorController@edit')->name('doctor_edit');
    Route::get('/show/{id}','DoctorController@show')->name('doctor_show');
    Route::post('/update/{id}','DoctorController@update')->name('doctor_update');
    Route::get('/delete/{id}','DoctorController@delete')->name('doctor_delete');
});
