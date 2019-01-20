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

Route::group(['prefix' => 'inventory', 'middleware' => 'auth'], function () {

    //Inventory Routes
    Route::get('/', 'InventoryWebController@index')->name('inventory')->middleware('read_access');
    Route::get('/create', 'InventoryWebController@create')->name('inventory_create')->middleware('create_access');
    Route::get('/sub-category/{id}', 'InventoryWebController@subCategory')->name('inventory_sub_category_show');
    Route::post('/store', 'InventoryWebController@store')->name('inventory_store')->middleware('create_access');
    Route::get('/show/{id}', 'InventoryWebController@show')->name('inventory_show')->middleware('read_access');
    Route::get('/edit/{id}', 'InventoryWebController@edit')->name('inventory_edit')->middleware('update_access');
    Route::post('/update/{id}', 'InventoryWebController@update')->name('inventory_update')->middleware('update_access');
    Route::get('/delete/{id}', 'InventoryWebController@destroy')->name('inventory_delete')->middleware('delete_access');
     //api ajax
    Route::get('/api/all/list', 'InventoryWebController@apiAllInventory')->name('inventory_api_all_inventory_list');
    Route::get('/api/all/list/find', 'InventoryWebController@apiFindInventory')->name('inventory_api_seach_inventory_items_key');


    // item search
    Route::get('/search/{id}', 'InventorySearchController@index')->name('inventory_search')->middleware('read_access');

    
});

Route::group(['prefix' => 'special-offer', 'middleware' => 'auth'], function () {
    Route::get('/', 'SpecialOfferController@index')->name('special_offer');
    Route::get('/create', 'SpecialOfferController@create')->name('special_offer_create');
    Route::post('/store', 'SpecialOfferController@store')->name('special_offer_store');
    Route::get('/edit/{id}', 'SpecialOfferController@edit')->name('special_offer_edit');
    Route::post('/update/{id}', 'SpecialOfferController@update')->name('special_offer_update');
    Route::get('/delete/{id}', 'SpecialOfferController@destroy')->name('special_offer_delete');

    Route::get('/save-claim/{id}', 'SpecialOfferController@saveClaim')->name('special_offer_save_claim');
});

Route::group(['prefix' => 'inventory/category', 'middleware' => 'auth'], function () {

    Route::get('/', 'CategoryWebController@index')->name('inventory_category')->middleware('read_access');
    Route::get('/create', 'CategoryWebController@create')->name('inventory_category_create')->middleware('create_access');
    Route::post('/store', 'CategoryWebController@store')->name('inventory_category_store')->middleware('create_access');
    Route::get('/edit/{id}', 'CategoryWebController@edit')->name('inventory_category_edit')->middleware('update_access');
    Route::post('/update/{id}', 'CategoryWebController@update')->name('inventory_category_update')->middleware('update_access');
    Route::get('/delete/{id}', 'CategoryWebController@destroy')->name('inventory_category_delete')->middleware('delete_access');
});

Route::group(['prefix' => 'inventory/subcategory', 'middleware' => 'auth'], function () {
    Route::get('/', 'SubCategoryWebController@index')->name('inventory_sub_category');
    Route::get('/create', 'SubCategoryWebController@add')->name('inventory_sub_category_add');
    Route::post('/store', 'SubCategoryWebController@store')->name('inventory_sub_category_store');
    Route::get('/edit/{id}', 'SubCategoryWebController@edit')->name('inventory_sub_category_edit');
    Route::post('/update/{id}', 'SubCategoryWebController@update')->name('inventory_sub_category_update');
    Route::get('/delete/{id}', 'SubCategoryWebController@destroy')->name('inventory_sub_category_delete');
});

