@extends('layouts.admin')

@section('title', 'Item Report '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('styles')
    <style>
        @media print {
            a[href]:after {
                content:"" !important;

            }
            a{
                text-decoration: none;
            }
            .uk-table tr td{
                white-space: nowrap;
                padding: 1px 0px;
                border: none !important;
                width: 100%;
                font-size: 11px !important;
            }
            .uk-table tr td:first-child,.uk-table tr th:first-child{
                text-align: left !important;
            }
            .uk-table tr th ,.uk-table:last-child tr td{

                white-space: nowrap;
                padding: 1px 5px;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                width: 100%;
                font-size: 11px !important;
            }

            body{
                margin-top: -40px;
            }
        }
    </style>
@endsection

@section('content_header')
    <div id="top_bar">
        <div class="md-top-bar">
            <ul id="menu_top" class="uk-clearfix">
                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Reports</span></a>
                    <div class="uk-dropdown">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li>Business Overview</li>
                            <li><a href="{{route('report_account_profit_loss')}}">Profit and Loss</a></li>
                            <li><a href="{{route('report_account_cash_flow_statement')}}">Cash Flow Statement</a></li>
                            <li><a href="{{route('report_account_balance_sheet')}}">Balance Sheet</a></li>
                            <li>Accountant</li>
                            <li><a href="{{route('report_account_transactions')}}">Account Transactions</a></li>
                            <li><a href="{{route('report_account_general_ledger_search')}}">General Ledger</a></li>
                            <li><a href="{{route('report_account_journal_search')}}">Journal Report</a></li>
                            <li><a href="{{route('report_account_trial_balance_search')}}">Trial Balance</a></li>
                            <li>Sales</li>
                            <li><a href="{{route('report_account_customer')}}">Sales by Customer</a></li>
                            <li><a href="">Sales by Item</a></li>
                            <li><a href="{{route('report_account_item')}}">Product Report</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="uk-width-medium-10-10 uk-container-center reset-print">
        <div class="uk-grid uk-grid-collapse" data-uk-grid-margin>
            <div class="uk-width-large-10-10">
                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview">
                        <div class="md-card-toolbar hidden-print">
                            <div class="md-card-toolbar-actions hidden-print" style="width: 100%">
                                <div data-uk-button-radio="{target:'.md-btn'}" style="float: right; ">
                                    <select data-md-selectize="" data-md-selectize-bottom="" data-uk-tooltip="{pos:'top'}" id="item_sub_category" title="Select Sub category">
                                        <option style="text-align: left;" value="">Select Sub Category...</option>
                                        <option value="all">All</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"> {{ $subcategory->item_sub_category_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="float: right">
                                    <input class="md-input" id="search_item" placeholder="Search Item Name " style="position: relative; top:-10px; width: 300px;" type="text">
                                    </input>
                                </div>
                                <i class="md-icon material-icons" id="invoice_print"></i>
                                <!--end  -->
                                <div aria-expanded="true" aria-haspopup="true" class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                    <a data-uk-modal="{target:'#coustom_setting_modal'}" href="#">
                                        <i class="material-icons">
                                            &#xE8B8;
                                        </i>
                                        <span>
                                        Custom Setting
                                    </span>
                                    </a>
                                </div>

                                <!--coustorm setting modal start -->
                                <div class="uk-modal" id="coustom_setting_modal">
                                    <div class="uk-modal-dialog">
                                        {!! Form::open(['url' => 'report/account/item', 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">Select Date Range and Transaction Type <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                        </div>

                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">From</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="from_date" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">To</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="to_date" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                            <button type="submit" name="submit" class="md-btn md-btn-flat md-btn-flat-primary">Search</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <!--end  -->
                            </div>

                            <h3 class="md-card-toolbar-heading-text large" id="invoice_name"></h3>
                        </div>
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                            <div class="uk-grid" >
                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img style="margin-bottom: -20px;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                    <p style="line-height: 5px; margin-top: 35px;" class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                    <p style="line-height: 5px;" class="heading_b">Item Report</p>
                                    <p style="line-height: 5px;" class="uk-text-small">From {{$start}} To {{$end}}</p>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <table class="uk-table" id="showItemFilterTable">
                                        
                                        <thead>
                                            <tr class="uk-text-upper">
                                                <th class="uk-text-left">Item Name</th>
                                                <th class="uk-text-right">Total Purchases</th>
                                                <th class="uk-text-right">Total Sales</th>
                                                <th class="uk-text-right">Stock In Hand</th>
                                                <th class="uk-text-right">Purchase Amount</th>
                                                <th class="uk-text-right">Sales Amount</th>
                                                <th class="uk-text-right">Profit</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $total_purchase        = 0;
                                                $total_sales           = 0;
                                                $total_stock_in        = 0;
                                                $total_purchase_amount = 0;
                                                $total_sales_amount    = 0;
                                                $total_profit_amount   = 0;
                                            @endphp

                                            @foreach($item as $itemData)

                                                @php
                                                    $sales              = $itemData->invoiceEntries()
                                                                                    ->join('invoices', 'invoices.id', '=', 'invoice_entries.invoice_id')
                                                                                    ->whereBetween('invoice_date', [$start, $end])
                                                                                    ->sum('quantity');

                                                    $purchase           = $itemData->billEntries()
                                                                                    ->join('bill', 'bill.id', '=', 'bill_entry.bill_id')
                                                                                    ->join('stock as s', 's.item_id', '=', 's.id')
                                                                                    ->where('s.item_id', '=', $itemData->id)
                                                                                    ->whereBetween('bill_date', [$start, $end])
                                                                                    ->sum('bill_entry.amount');

                                                    $_purchase          = $itemData->stocks()
                                                                                    ->whereBetween('date', [$start, $end])
                                                                                    ->sum('total');

                                                    $_sales             = $itemData->total_sales;

                                                    $profit             = $sales - $purchase;
                                                @endphp

                                                <tr class="uk-table-middle">
                                                    <td style="display: none;">{{ $itemData->item_sub_category_id }}</td>
                                                    <td class="uk-text-left">
                                                        <a href="{{ route('report_account_item_details', [$itemData->id, $start, $end])}}">
                                                            {{ $itemData->item_name }}
                                                        </a>
                                                    </td>
                                                    <td class="uk-text-right">{{ $_purchase  }}</td>
                                                    <td class="uk-text-right">{{ $_sales }}</td>
                                                    <td class="uk-text-right">{{ $_stock = $itemData->total_purchases - $itemData->total_sales }}</td>
                                                    <td class="uk-text-right">{{ $purchase }}</td>
                                                    <td class="uk-text-right">{{ $sales }}</td>
                                                    <td class="uk-text-right">{{ $profit  }}</td>
                                                </tr>

                                                @php
                                                    $total_purchase         += $_purchase;
                                                    $total_sales            += $_sales;
                                                    $total_stock_in         += $_stock;
                                                    $total_purchase_amount  += $purchase;
                                                    $total_sales_amount     += $sales;
                                                    $total_profit_amount    += $profit;

                                                    $purchase                = 0;
                                                    $sales                   = 0;
                                                    $profit                  = 0;
                                                @endphp

                                            @endforeach

                                            <tr id="itemTotalValue">
                                                <td class="uk-text-left">Total</td>
                                                <td class="uk-text-right" id="totalPurchaseQty">{{ $total_purchase }}</td>
                                                <td class="uk-text-right" id="totalSales">{{ $total_sales }}</td>
                                                <td class="uk-text-right" id="totalStockIn">{{ $total_stock_in }}</td>
                                                <td class="uk-text-right" id="totalPurchaseAmount">{{ $total_purchase_amount }}</td>
                                                <td class="uk-text-right" id="totalSalesAmount">{{ $total_sales_amount }}</td>
                                                <td class="uk-text-right" id="totalAmount">{{ $total_profit_amount }}</td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <span class="uk-text-muted uk-text-small uk-text-italic">Notes:</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- handlebars.js -->
    <script src="{{ url('admin/bower_components/handlebars/handlebars.min.js')}}"></script>
    <script src="{{ url('admin/assets/js/custom/handlebars_helpers.min.js')}}"></script>

    <!--  invoices functions -->
    <script src="{{ url('admin/assets/js/pages/page_invoices.min.js')}}"></script>
    <script type="text/javascript">

        //Dropdown Item Name Search by Sub Category
        $("#item_sub_category").on('change',function () {

            var sub_cat_id = $(this).val();

            // Declare variables
            var  filter, table, tr, td, i, item_total, total_purchase_qty,purchase_qty, total_sales, sales_value,
                total_stock_in, stock_in, total_purchase_amount, purchase_amount, total_sales_amount, sales_amount, total_profit, profit;


            total_purchase_qty=0;
            total_sales=0;
            total_stock_in=0;
            total_purchase_amount=0;
            total_sales_amount=0;
            total_profit=0;

            filter = sub_cat_id;
            table = document.getElementById("showItemFilterTable");
            item_total = document.getElementById("itemTotalValue");

            tr = table.getElementsByTagName("tr");

            if(filter == 'all')
            {
                for (i = 0; i < tr.length; i++) {

                    td = tr[i].getElementsByTagName("td")[0];
                    purchase_qty = tr[i].getElementsByTagName("td")[2];
                    sales_value = tr[i].getElementsByTagName("td")[3];
                    stock_in = tr[i].getElementsByTagName("td")[4];
                    purchase_amount = tr[i].getElementsByTagName("td")[5];
                    sales_amount = tr[i].getElementsByTagName("td")[6];
                    profit = tr[i].getElementsByTagName("td")[7];

                    if (td) {
                        console.log(sales_value.innerHTML);
                        tr[i].style.display = "";
                        total_purchase_qty += parseFloat(purchase_qty.innerHTML);
                        total_sales += parseFloat(sales_value.innerHTML);
                        total_stock_in += parseFloat(stock_in.innerHTML);
                        total_purchase_amount += parseFloat(purchase_amount.innerHTML);
                        total_sales_amount += parseFloat(sales_amount.innerHTML);
                        total_profit += parseFloat(profit.innerHTML);
                    }
                }

                document.getElementById("totalPurchaseQty").innerHTML = total_purchase_qty;
                document.getElementById("totalSales").innerHTML = total_sales;
                document.getElementById("totalStockIn").innerHTML = total_stock_in;
                document.getElementById("totalPurchaseAmount").innerHTML = total_purchase_amount;
                document.getElementById("totalSalesAmount").innerHTML = total_sales_amount;
                document.getElementById("totalAmount").innerHTML = total_profit;

                return false;
            }


            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[0];
                purchase_qty = tr[i].getElementsByTagName("td")[2];
                sales_value = tr[i].getElementsByTagName("td")[3];
                stock_in = tr[i].getElementsByTagName("td")[4];
                purchase_amount = tr[i].getElementsByTagName("td")[5];
                sales_amount = tr[i].getElementsByTagName("td")[6];
                profit = tr[i].getElementsByTagName("td")[7];

                if (td) {

                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        total_purchase_qty += parseFloat(purchase_qty.innerHTML);
                        total_sales += parseFloat(sales_value.innerHTML);
                        total_stock_in += parseFloat(stock_in.innerHTML);
                        total_purchase_amount += parseFloat(purchase_amount.innerHTML);
                        total_sales_amount += parseFloat(sales_amount.innerHTML);
                        total_profit += parseFloat(profit.innerHTML);
                    } else {
                        tr[i].style.display = "none";
                        item_total.style.display = "";
                    }
                }
            }

              document.getElementById("totalPurchaseQty").innerHTML = total_purchase_qty;
              document.getElementById("totalSales").innerHTML = total_sales;
              document.getElementById("totalStockIn").innerHTML = total_stock_in;
              document.getElementById("totalPurchaseAmount").innerHTML = total_purchase_amount;
              document.getElementById("totalSalesAmount").innerHTML = total_sales_amount;
              document.getElementById("totalAmount").innerHTML = total_profit;
        });

        //search Item Name
        $("#search_item").on("input",function () {
            var item_id = $(this).val().toUpperCase();
            // Declare variables
            var  filter, table, tr, td, i;

            filter = item_id
            table = document.getElementById("showItemFilterTable");
            tr = table.getElementsByTagName("tr");
            if(filter=='all')
            {
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {

                        tr[i].style.display = "";

                    }
                }
                return false;
            }
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[1];

                if (td) {

                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";

                    } else {
                        tr[i].style.display = "none";
                    }

                }

            }
        })


        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');
    </script>
@endsection
