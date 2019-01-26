<?php


Route::group(['prefix' => 'department'], function () {
    Route::get('/index','DepartmentController@index')->name('department_index');
    Route::get('/create','DepartmentController@create')->name('department_create');
    Route::post('/store','DepartmentController@store')->name('department_store');
    Route::get('/edit/{id}','DepartmentController@edit')->name('department_edit');
    Route::post('/update/{id}','DepartmentController@update')->name('department_update');
    Route::get('/delete/{id}','DepartmentController@delete')->name('department_delete');
});
