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

Route::group(['prefix' => 'contact', 'middleware' => 'auth'], function () {

    //Contact Routes
    Route::get('/{category_id}', 'ContactWebController@index')->name('contact')->middleware('read_access');
    Route::get('/create/{category_id}', 'ContactWebController@create')->name('contact_create')->middleware('create_access');
    Route::get('/create_customer', 'ContactWebController@create_customer')->name('contact_create_customer')->middleware('create_access');
    Route::post('/store/{category_id}', 'ContactWebController@store')->name('contact_store')->middleware('create_access');
    Route::get('/view/{category_id}/{id}', 'ContactWebController@show')->name('contact_view')->middleware('read_access');
    Route::get('/edit/{category_id}/{id}', 'ContactWebController@edit')->name('contact_edit')->middleware('update_access');
    Route::post('/update/{category_id}/{id}', 'ContactWebController@update')->name('contact_update')->middleware('update_access');
    Route::get('/delete/{id}', 'ContactWebController@destroy')->name('contact_delete')->middleware('delete_access');
    Route::get('/pdf', 'ContactWebController@pdf')->name('contact_pdf')->middleware('read_access');
    Route::get('/remove/{category_id}/{id}', 'ContactWebController@destroy')->name('contact_remove')->middleware('delete_access');

    
    Route::get('/edit-agent/{id}', 'ContactWebController@editAgent')->name('contact_edit_agent')->middleware('update_access');
    Route::post('/update-agent/{id}', 'ContactWebController@updateAgent')->name('contact_update_agent')->middleware('update_access');
    Route::get('/remove-agent/{id}', 'ContactWebController@destroyAgent')->name('contact_remove_agent')->middleware('delete_access');
    Route::get('/view-agent/{id}', 'ContactWebController@showAgent')->name('contact_view_agent')->middleware('read_access');
   
   
    //Contact Search Routes
    Route::get('/search/{id}', 'InventorySearchController@index')->name('contact_search')->middleware('read_access');


});


Route::group(['prefix' => 'road', 'middleware' => 'auth'], function () {
    Route::get('/', 'RoadController@index')->name('road_index');
    Route::get('/create', 'RoadController@create')->name('road_create');
    Route::post('/store', 'RoadController@store')->name('road_store');
    Route::get('/edit/{id}', 'RoadController@edit')->name('road_edit');
    Route::post('/update/{id}', 'RoadController@update')->name('road_update');
    Route::get('/delete/{id}', 'RoadController@destroy')->name('road_delete');
});


Route::group(['prefix' => 'contact/category', 'middleware' => 'auth'], function () {

    //Category Routes
    Route::get('/', 'CategoryWebController@index')->name('category')->middleware('read_access');
    Route::get('/create', 'CategoryWebController@create')->name('category_create')->middleware('create_access');
    Route::post('/store', 'CategoryWebController@store')->name('category_store')->middleware('create_access');
    Route::get('/edit/{id}', 'CategoryWebController@edit')->name('category_edit')->middleware('update_access');
    Route::post('/update/{id}', 'CategoryWebController@update')->name('category_update')->middleware('update_access');
    Route::get('/delete/{id}', 'CategoryWebController@destroy')->name('category_delete')->middleware('delete_access');

});


Route::group(['prefix' => 'api/contact', 'middleware' => 'auth'], function () {

    Route::get('/get-contact-category', 'CategoryApiController@getContactCategory')->middleware('auth');
    Route::get('/get-contact/{id}', 'ContactApiController@getContact')->middleware('auth');
    Route::get('/get/all/contact/list/{id}', 'ContactApiController@all')->name("contact_api_get_all_contact_list")->middleware('auth');
    Route::get('/get/all/contact/find', 'ContactApiController@findByName')->name("contact_api_get_all_contact_find_by_name")->middleware('auth');

});