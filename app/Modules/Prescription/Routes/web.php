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

Route::group(['prefix' => 'prescription'], function () {
    Route::get('/','PrescriptionController@index')->name('prescription_index');
    Route::get('/create','PrescriptionController@create')->name('prescription_create');
    Route::post('/store','PrescriptionController@store')->name('prescription_store');
    Route::get('/show/{id}','PrescriptionController@show')->name('prescription_show');
    Route::get('/edit/{id}','PrescriptionController@edit')->name('prescription_edit');
    Route::post('/update/{id}','PrescriptionController@update')->name('prescription_update');
    Route::get('/delete/{id}','PrescriptionController@delete')->name('prescription_delete');




    Route::get('/medicine-taking-schedule/{type_id}','PrescriptionController@medicineTakingSchedule')->name('prescription_medicine_taking_schedule');
});
