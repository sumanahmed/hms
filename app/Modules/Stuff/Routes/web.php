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

Route::group(['prefix' => 'stuff'], function () {

    Route::get('/index','StuffController@index')->name('stuff_index');
    Route::get('/create','StuffController@create')->name('stuff_create');
    Route::post('/store','StuffController@store')->name('stuff_store');
    Route::get('/edit/{id}','StuffController@edit')->name('stuff_edit');
    Route::post('/update/{id}','StuffController@update')->name('stuff_update');
    Route::get('/delete/{id}','StuffController@delete')->name('stuff_delete');

});

Route::group(['prefix' => 'stuff-type'], function () {

    Route::get('/index','StuffTypeController@index')->name('stuff_type_index');
    Route::get('/create','StuffTypeController@create')->name('stuff_type_create');
    Route::post('/store','StuffTypeController@store')->name('stuff_type_store');
    Route::get('/edit/{id}','StuffTypeController@edit')->name('stuff_type_edit');
    Route::post('/update/{id}','StuffTypeController@update')->name('stuff_type_update');
    Route::get('/delete/{id}','StuffTypeController@delete')->name('stuff_type_delete');

});
