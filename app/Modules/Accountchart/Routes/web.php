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
 


Route::group(['prefix' => 'account-chart', 'middleware' => 'auth'], function () {

    //Account Charts Routes
    Route::get('/', 'AccountChartWebController@index')->name('account_chart')->middleware('read_access');
    Route::get('/create', 'AccountChartWebController@create')->name('account_chart_create')->middleware('create_access');
    Route::post('/store', 'AccountChartWebController@store')->name('account_chart_store')->middleware('create_access');
    Route::get('/show/{id}', 'AccountChartWebController@show')->name('account_chart_show')->middleware('read_access');
    Route::get('/edit/{id}', 'AccountChartWebController@edit')->name('account_chart_edit')->middleware('update_access');
    Route::post('/update/{id}', 'AccountChartWebController@update')->name('account_chart_update')->middleware('update_access');
    Route::get('/delete/{id}', 'AccountChartWebController@destroy')->name('account_chart_delete')->middleware('delete_access');


    Route::post('/add-gl', 'AccountChartWebController@addGL')->name('add_gl');
    Route::post('/add-pgl', 'AccountChartWebController@addPGL')->name('add_pgl');

    //Account GL
    Route::get('/account-gl', 'AccountChartWebController@accountGl')->name('account_gl');
    Route::get('/account-gl-edit/{id}', 'AccountChartWebController@accountGlEdit')->name('account_gl_edit');
    Route::post('/account-gl-update/{id}', 'AccountChartWebController@accountGlUpdate')->name('account_gl_update');
    Route::get('/account-gl-delete/{id}', 'AccountChartWebController@accountGlDelte')->name('account_gl_delete');

    //Account PGL
    Route::get('/account-pgl', 'AccountChartWebController@accountPGl')->name('account_pgl');
    Route::get('/account-pgl-edit/{id}', 'AccountChartWebController@accountPGlEdit')->name('account_pgl_edit');
    Route::post('/account-pgl-update/{id}', 'AccountChartWebController@accountPGlUpdate')->name('account_pgl_update');
    Route::get('/account-pgl-delete/{id}', 'AccountChartWebController@accountPGlDelte')->name('account_pgl_delete');

});
