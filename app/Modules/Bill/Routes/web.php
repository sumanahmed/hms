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

Route::group(['prefix' => 'purchase-invoice' , 'middleware' => 'auth'], function () {
    Route::get('/', 'BillWebController@index')->name('purchase_invoice')->middleware('read_access');
});

Route::group(['prefix' => 'purchase-invoice' , 'middleware' => 'auth'], function () {
    Route::get('/', 'BillWebController@index')->name('purchase_invoice');
    Route::get('create', 'BillWebController@create')->name('purchase_invoice_create');
    Route::post('store', 'BillWebController@store')->name('purchase_invoice_store');
    Route::get('show/{id}', 'BillWebController@show')->name('purchase_invoice_show');
    Route::get('edit/{id}', 'BillWebController@edit')->name('purchase_invoice_edit');
    Route::post('update/{id}', 'BillWebController@update')->name('purchase_invoice_update');
    Route::get('delete/{id}', 'BillWebController@destroy')->name('purchase_invoice_delete');

    Route::get('ajax-product/{id}', 'BillWebController@ajaxProduct')->name('purchase_invoice_ajax_product');
    Route::get('ajax-free-item/{id}/{quantity}/{bill_date}' , 'BillWebController@ajaxFreeItem')->name('purchase_invoice_ajax_free_item');

    Route::post('/', 'BillWebController@search')->name('purchase_invoice')->middleware('read_access');
    Route::post('show/{id}', 'BillWebController@showupload')->name('purchase_invoice_show_upload');
    Route::get('mark/update/{id}', 'BillWebController@markupdate')->name('purchase_invoice_update_mark')->middleware('update_access');
    Route::post('use-bill-excess-payment', 'BillWebController@useExcessPayment')->name('post_bill_excess_payment')->middleware('auth');
    Route::get('/purchase-return/{id}' , 'PurchaseReturn\WebController@create')->name('purchase_return_index');
    Route::post('/purchase-return/update/{id}' , 'PurchaseReturn\WebController@update')->name('purchase_return_update');

});

//Receive Undelivered Items
Route::group(['prefix' => 'receive-undelivered', 'middleware' => 'auth'], function () {
    Route::get('/create', 'ReceiveUndeliveredItemController@create')->name('receive_undelivered');
    Route::post('/update', 'ReceiveUndeliveredItemController@update')->name('recevie_undelivered_update');
    Route::get('/ajax-item/{id}', 'ReceiveUndeliveredItemController@getItem')->name('recevie_undelivered_ajax_item');
    Route::get('/ajax-undelivered-item/{item_id}/{company_id}', 'ReceiveUndeliveredItemController@getUndeliveredItem')->name('undelivered_item');
});

//Free Received Item
Route::group(['prefix' => 'free-received', 'middleware' => 'auth'], function () {
    Route::get('/', 'FreeReceivedController@index')->name('free_received');
    Route::get('/create/{id}', 'FreeReceivedController@create')->name('free_received_create');
    Route::post('/store', 'FreeReceivedController@store')->name('free_received_store');
    Route::get('/edit/{id}', 'FreeReceivedController@edit')->name('free_received_edit');
    Route::post('/update/{id}', 'FreeReceivedController@update')->name('free_received_update');
    Route::get('/delete/{id}', 'FreeReceivedController@destroy')->name('free_received_delete');

    Route::get('/history/{id}', 'FreeReceivedController@history')->name('free_received_history');
    Route::get('/history/edit/{id}', 'FreeReceivedController@historyEdit')->name('free_received_history_edit');
    Route::post('/history/update/{id}', 'FreeReceivedController@historyUpdate')->name('free_received_history_update');
});

Route::group(['prefix' => 'api/bill', 'middleware' => 'auth'], function () {

    Route::get('/get-item-rate/{id}', 'BillApiController@getItemRate')->middleware('auth');
    Route::get('/get-bill-entry/{id}', 'BillApiController@getBillEntry')->middleware('auth');
    Route::get('/get-due-balance/{id}', 'BillApiController@getDueBalance')->middleware('auth');

});
