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
