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

Route::group(['prefix' => 'patient'], function () {
    Route::get('/index','PatientController@index')->name('patient_index');
    Route::get('/create','PatientController@create')->name('patient_create');
    Route::post('/store','PatientController@store')->name('patient_store');
    Route::get('/show/{id}','PatientController@show')->name('patient_show');
    Route::get('/edit/{id}','PatientController@edit')->name('patient_edit');
    Route::post('/update/{id}','PatientController@update')->name('patient_update');
    Route::get('/delete/{id}','PatientController@delete')->name('patient_delete');
    Route::get('/bill/{id}','PatientController@bill')->name('patient_bill');


    Route::get('/prescription/{id}','PatientController@prescription')->name('patient_prescription');
    Route::get('/get-bed/{ward_id}','PatientController@patientGetBed')->name('patient_get_bed');

    Route::get('/status/create/{id}','PatientController@statusCreate')->name('status_create');
    Route::post('/status/store/{id}','PatientController@statusStore')->name('patient_status');

    Route::get('/pay-amount/{id}','PatientController@payAmount')->name('patient_pay_amount');
});
