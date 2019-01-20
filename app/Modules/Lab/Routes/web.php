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

Route::group(['prefix' => 'lab'], function () {
    Route::get('/','LabController@index')->name('lab_index');
    Route::get('/take-test/{id}/{test_category_id}','LabController@takeTest')->name('take_test');
    Route::post('/store','LabController@store')->name('lab_store');
    Route::get('/edit/{id}','LabController@edit')->name('lab_edit');
    Route::post('/update/{id}','LabController@update')->name('lab_update');
    Route::get('/delete/{id}','LabController@delete')->name('lab_delete');

    Route::get('/complete-test','LabController@completeTest')->name('lab_complete_test');
    Route::get('/test-report','LabController@testReport')->name('lab_test_report');
    Route::get('/test-report/{id}','LabController@testLabReportComplete')->name('lab_test_report_complete');
    Route::get('/test-report-show/{id}','LabController@testReportShow')->name('lab_test_report_show');
});
