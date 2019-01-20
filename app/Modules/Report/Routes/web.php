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


Route::group(['prefix' => 'report','middleware'=>'auth'], function () {

        Route::get('/', 'ReportWebController@index')->name('report')->middleware('read_access');
        Route::get('account/transactions', 'ReportWebController@accountTransactions')->name('report_account_transactions')->middleware('read_access');
        Route::post('account/transactions', 'ReportWebController@accountTransactionsSearch')->name('report_account_transactions_search')->middleware('read_access');
        Route::get('account/transactions/{id}', 'ReportWebController@accountTransactionsAccountSearch')->name('report_account_transactions_account_search')->middleware('read_access');
        Route::get('account/general/ledger', 'ReportWebController@accountGeneralLedger')->name('report_account_general_ledger_search')->middleware('read_access');
        Route::post('account/general/ledger', 'ReportWebController@accountGeneralLedgerSearch')->name('report_account_general_ledger_search')->middleware('read_access');
        Route::get('account/general/ledger/list/api', 'ReportApiController@genaralLedger')->name('report_account_general_ledger_list_api');

        Route::get('account/journal', 'ReportWebController@accountJournal')->name('report_account_journal_search')->middleware('read_access');
        Route::post('account/journal', 'ReportWebController@accountJournalSearch')->name('report_account_journal_search')->middleware('read_access');
        Route::get('account/trial/balance', 'ReportWebController@accountTrialBalance')->name('report_account_trial_balance_search')->middleware('read_access');
        Route::post('account/trial/balance', 'ReportWebController@accountTrialBalanceSearch')->name('report_account_trial_balance_search')->middleware('read_access');
        Route::get('account/profitandloss', 'ReportWebController@ProfitAndLoss')->name('report_account_ProfitAndLoss')->middleware('read_access');
        Route::post('account/profitandloss', 'ReportWebController@ProfitAndLossbyfilter')->name('report_account_ProfitAndLoss_by_filter')->middleware('read_access');
        Route::get('account/profit/loss', 'ReportWebController@ProfitLoss')->name('report_account_profit_loss')->middleware('read_access');
        Route::get('account/cash/flow/statement', 'ReportWebController@CashFlowStatement')->name('report_account_cash_flow_statement')->middleware('read_access');
        Route::get('account/balance/sheet', 'ReportWebController@BalanceSheet')->name('report_account_balance_sheet')->middleware('read_access');
        Route::get('account/balance/and/sheet', 'ReportWebController@BalanceAndSheet')->name('report_account_balance_and_sheet')->middleware('read_access');
        Route::post('account/balance/and/sheet', 'ReportWebController@BalanceAndSheetbyfilter')->name('report_account_balance_and_sheet_filter')->middleware('read_access');
        Route::get('account/customer', 'ReportWebController@customer')->name('report_account_customer')->middleware('read_access');
        Route::get('account/customer/category/filter/{id}', 'ReportWebController@customerCategory')->name('report_account_customer_category_filter')->middleware('read_access');
        Route::get('account/customer/category/filter/{start}/{end}/{id}', 'ReportWebController@customerCategoryDate')->name('report_account_customer_category_filter')->middleware('read_access');


        Route::post('account/customer', 'ReportWebController@customerSearch')->name('report_account_customer_search')->middleware('read_access');
        Route::get('account/customer/{id}', 'ReportWebController@customerDetails')->name('report_account_customer_id')->middleware('read_access');
        Route::post('account/customer/{id}', 'ReportWebController@customerDetailsSearch')->name('report_account_customer_id_search')->middleware('read_access');
        Route::get('account/item', 'ReportWebController@item')->name('report_account_item')->middleware('read_access');
        Route::post('account/item', 'ReportWebController@filter_item')->name('report_account_item_filter');
        Route::get('account/item/{id}/{start}/{end}', 'ReportWebController@itemDetails')->name('report_account_item_details')->middleware('read_access');

    //contact
        Route::get('account/list', 'ReportContactController@index')->name('report_account_contact_list')->middleware('read_access');
        Route::post('account/list', 'ReportContactController@indexSearch')->name('report_account_contact_list_search')->middleware('read_access');
        Route::post('account/alpha/list', 'ReportContactController@AlpahabetSearch')->name('report_account_contact_list_alpha_search');
        Route::get('account/api/alpha/search/list', 'ReportContactController@apiAlphaSearch')->name('report_account_contact_api_list_alpha_search');
        Route::get('account/contact/filter/list', 'ReportContactController@contactBySearch')->name('report_account_contact_list_contact_by_search');
        Route::get('api/account/contact/name/list', 'ReportContactController@apiContactName')->name('report_account_contact_list_apiContactName_by_search');

        Route::get('account/details/report/{id}/{branch}/{start}/{end}', 'ReportContactController@ContactDetails')->name('report_account_single_contact_details')->middleware('read_access');
        Route::get('account/mail/{id}/{branch}/{start}/{end}/{display_name}', 'ReportContactController@mailView')->name('report_mail_send_view')->middleware('read_access');
        Route::post('account/mail/send/{id}', 'ReportContactController@mailSend')->name('report_mail_send')->middleware('read_access');
        Route::post('account/details/report/{id}', 'ReportContactController@ContactDetailsSearch')->name('report_account_single_contact_details_by_date')->middleware('read_access');

    //contactwise
        Route::get('accounts/contactwise/item', 'ContactWiseItemController@index')->name('report_account_contact_wise_item_all');
        Route::get('api/accounts/contactwise/item/list', 'ContactWiseItemController@apiContactItemList')->name('report_account_api_Contact_Item_List');

        Route::post('accounts/contactwise/item', 'ContactWiseItemController@filter')->name('report_account_contact_wise_item_filter');
        Route::get('accounts/contactwise/item/date', 'ContactWiseItemController@dateFilter')->name('report_account_contact_wise_item_filter_date_api');
        Route::get('accounts/contactwise/item/alpa', 'ContactWiseItemController@alpaFilter')->name('report_account_contact_wise_item_filter_alpa_api');
        Route::get('accounts/contactwise/item/alpa/name', 'ContactWiseItemController@alpaNameFilter')->name('report_account_contactwise_api_list_alpha_search');
        Route::get('accounts/contactwise/item/alpa/name/api/search', 'ContactWiseItemController@apiContactName')->name('report_account_contactwise_api_list_alpha_name_search');
    //contactwise front filter

    // contactwise details
        Route::get('accounts/contactwise/item/details', 'ContactWiseItemController@apiContactItemDetails')->name('report_account_api_Contact_Item_Details');
        Route::post('accounts/contactwise/item/details', 'ContactWiseItemController@apiContactItemDetailsFilter')->name('report_account_api_Contact_Item_Details_filter');
        Route::get('accounts/contactwise/item/details/show/{id}/{branch}/{start}/{end}', 'ContactWiseItemController@apiContactItemDetailsShow')->name('report_account_api_Contact_Item_Details_show');

        Route::get('cashbook', 'ReportWebController@cashbook')->name('report_cashbook')->middleware('read_access');
        Route::post('cashbook', 'ReportWebController@cashbooksearch')->name('report_cashbook_search')->middleware('read_access');


        Route::post('sales/agent', 'SalesCommissionReportController@filterbydate')->name('reportSalesdateby_agent')->middleware('read_access');
        Route::get('sales/agent', 'SalesCommissionReportController@index')->name('report_Sales_by_agent')->middleware('read_access');
        Route::get('sales/agent/details/{id}/{start}/{end}', 'SalesCommissionReportController@details')->name('report_Sales_by_agent_details')->middleware('read_access');
        Route::post('sales/agent/details', 'SalesCommissionReportController@detailsbydate')->name('report_Sales_by_agent_detailsbydate')->middleware('read_access');


        //Contact Wise Report
        Route::get('contact/wise/item', 'ContactWiseReportController@index')->name('report_contact_wise')->middleware('read_access');
        Route::post('contact/wise/item', 'ContactWiseReportController@index')->name('report_contact_wise')->middleware('read_access');
        Route::get('contact/wise/item/details/{id}/{start}/{end}', 'ContactWiseReportController@details')->name('show_details_contact_wise_report')->middleware('read_access');
        Route::post('contact/wise/item/details/{id}/{start}/{end}', 'ContactWiseReportController@details')->name('show_details_contact_wise_report')->middleware('read_access');

        //Purchase By Vendor
        Route::get('vendor', 'PurchaseByVendorController@index')->name('report_purchase_by_vendor')->middleware('read_access');
        Route::post('vendor', 'PurchaseByVendorController@index')->name('report_purchase_by_vendor')->middleware('read_access');
        Route::get('vendor/details/{id}/{start}/{end}', 'PurchaseByVendorController@details')->name('show_details_purchase_by_vendor_report')->middleware('read_access');
        Route::post('vendor/details/{id}/{start}/{end}', 'PurchaseByVendorController@details')->name('show_details_purchase_by_vendor_report')->middleware('read_access');
    //Stock
    Route::get('stock/details/{id}/{start}/{end}', 'Stock\PostController@details')->name('report_stock_details_item')->middleware('read_access');
    Route::post('stock/details/{id}/{start}/{end}', 'Stock\PostController@details')->name('report_stock_details_item')->middleware('read_access');

    // incomestatement visa
        Route::get('recruit/incomestatement', 'IncomeStatementController@index')->name('account_report_incomestatement_visa_index');
        Route::get('incomestatement/visa/api/datalist', 'IncomeStatementController@apiIndexDatalist')->name('api_index_data_account_report_incomestatement_visa_index');

        Route::get('incomestatement/visa/account/details/{start}/{end}/{id}/{group}', 'IncomeStatementController@accountDetails')->name('index_data_account_report_account_details_all');
        Route::get('incomestatement/visa/account/details/{id}/{group}', 'IncomeStatementController@accountDetailsFilter')->name('deatils_data_account_report_account_details_filter');

        Route::get('incomestatement/visa/account/details/api/{start}/{end}/{id}', 'IncomeStatementController@apiAccountDetails')->name('Api_index_data_account_report_account_details_all');
        Route::post('recruit/incomestatement', 'IncomeStatementController@indexFilter')->name('account_report_incomestatement_visa_index_filter');

    // total transaction
        Route::get('totaltransaction/index', 'TotalTransectionController@index')->name('account_report_total_transaction_index_data');
        Route::post('totaltransaction/index', 'TotalTransectionController@filter')->name('account_report_total_transaction_index_data_filter');

    //Expense Reports
        Route::get('expense/ledger', 'ReportExpenseController@expenseLedger')->name('expenseLedger');
        Route::post('expense/ledger', 'ReportExpenseController@expenseLedgerFilter')->name('expenseLedgerFilter');

        Route::get('expense/api/alpha/search/list', 'ReportExpenseController@apiAlphaSearch')->name('report_account_expense_api_list_alpha_search');

    //outlet record
        Route::get('outlet-record', 'OutletRecordController@index')->name('outlet_record');
        Route::get('outlet-record/ajax-road/{id}', 'OutletRecordController@ajaxRoad')->name('outlet_record_ajax_road');
        Route::post('outlet-record/filter', 'OutletRecordController@filter')->name('outlet_record_filter');
        Route::get('outlet-record/filter', 'OutletRecordController@index')->name('outlet_record_filter_get');

    //Special Offer
        Route::get('special-offer', 'SpecialOfferController@index')->name('report_special_offer');
        Route::post('special-offer/filter', 'SpecialOfferController@filter')->name('report_special_offer_filter');
        Route::get('special-offer/filter', 'SpecialOfferController@index')->name('report_special_offer_filter_get');

    //Report Product List
        Route::get('product-list', 'ProductController@index')->name('report_product_list');
        Route::post('product-list/filter', 'ProductController@filter')->name('report_product_filter');
        Route::get('product-list/filter', 'ProductController@index')->name('report_product_filter_get');

    //Purchase Report
        Route::get('purchase-report', 'PurchaseReportController@index')->name('purchase_report');
        Route::post('purchase-report/filter', 'PurchaseReportController@filter')->name('purchase_report_filter');
        Route::get('purchase-report/filter', 'PurchaseReportController@index')->name('purchase_report_get');

    //Stock Report
        Route::get('stock-report', 'StockReportController@index')->name('stock_report');
        Route::post('stock-report/filter', 'StockReportController@filter')->name('stock_report_filter');
        Route::get('stock-report/filter', 'StockReportController@index')->name('stock_report_get');

    //Undelivered Report
        Route::get('undelivered-report', 'UndeliveredReportController@index')->name('undelivered_report');
        Route::post('undelivered-report/filter', 'UndeliveredReportController@filter')->name('undelivered_report_filter');
        Route::get('undelivered-report/filter', 'UndeliveredReportController@index')->name('undelivered_report_get');

    //Damage Report
        Route::get('damaged-report', 'DamageReportController@index')->name('damage_report');
        Route::post('damaged-report/filter', 'DamageReportController@filter')->name('damage_report_filter');
        Route::get('damaged-report/filter', 'DamageReportController@index')->name('damage_report_get');

    //Free Details Report
        Route::get('free-detail-report', 'FreeDetailsReportController@index')->name('free_details_report');
        Route::post('free-detail-report/filter', 'FreeDetailsReportController@filter')->name('free_details_report_filter');
        Route::get('free-detail-report/filter', 'FreeDetailsReportController@index')->name('free_details_report_get');

    //Sales Report sales
        Route::get('sales-report', 'SalesReportController@index')->name('sales_report');
        Route::post('sales-report/filter', 'SalesReportController@filter')->name('sales_report_filter');
        Route::get('sales-report/filter', 'SalesReportController@index')->name('sales_report_get');

    //Sales Return Report
        Route::get('sales-return-report', 'SalesReturnReportController@index')->name('sales_return_report');
        Route::post('sales-return-report/filter', 'SalesReturnReportController@filter')->name('sales_return_report_filter');
        Route::get('sales-return-report/filter', 'SalesReturnReportController@index')->name('sales_return_report_get');

    //Customer wise Report
        Route::get('customer-wise-report', 'CustomerwiseReportController@index')->name('customer_wise_report');
        Route::post('customer-wise-report/filter', 'CustomerwiseReportController@filter')->name('customer_wise_report_filter');
        Route::get('customer-wise-report/filter', 'CustomerwiseReportController@index')->name('customer_wise_report_get');

    //Sales Summary
        Route::get('sales-summary', 'SalesSummaryController@index')->name('sales_summary');
        Route::post('sales-summary/filter', 'SalesSummaryController@filter')->name('sales_summary_filter');
        Route::get('sales-summary/filter', 'SalesSummaryController@index')->name('sales_summary_get');

});
