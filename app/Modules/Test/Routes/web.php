<?php

//Test Category
Route::group(['prefix' => 'test/test-category'], function () {
    Route::get('/','TestCategoryController@index')->name('test_category_index');
    Route::get('/create','TestCategoryController@create')->name('test_category_create');
    Route::post('/store','TestCategoryController@store')->name('test_category_store');
    Route::get('/edit/{id}','TestCategoryController@edit')->name('test_category_edit');
    Route::post('/update/{id}','TestCategoryController@update')->name('test_category_update');
    Route::get('/delete/{id}','TestCategoryController@delete')->name('test_category_delete');
});

//Test
Route::group(['prefix' => 'test'], function () {
    Route::get('/','TestController@index')->name('test_index');
    Route::get('/create/{id}','TestController@create')->name('test_create');
    Route::post('/store','TestController@store')->name('test_store');
    Route::get('/edit/{id}','TestController@edit')->name('test_edit');
    Route::post('/update/{id}','TestController@update')->name('test_update');
    Route::get('/delete/{id}','TestController@delete')->name('test_delete');
});
