@extends('layouts.admin')

@section('title', 'All Report')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section("styles")
    <style>
        #contact_name_search {

        }

        #myUL {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myUL li a {
            border: 1px solid #ddd;
            margin-top: -1px; /* Prevent double borders */
            background-color: #f6f6f6;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            color: black;
            display: block
        }

        #myUL li a:hover:not(.header) {
            background-color: #eee;
        }
       /* */
        #myUL_contact_wise {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myUL_contact_wise li a {
            border: 1px solid #ddd;
            margin-top: -1px; /* Prevent double borders */
            background-color: #f6f6f6;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            color: black;
            display: block
        }

        #myUL_contact_wise li a:hover:not(.header) {
            background-color: #eee;
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
                            <li id="profit"><a href="{{route('report_account_profit_loss')}}">Profit and Loss</a></li>
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
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                <div class="uk-width-large-1-2 uk-width-medium-1-2">
                   
                    <h5><strong>Accounts</strong></h5>
                    <ul class="md-list">
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_cashbook')}}"><i class="material-icons">&#xE315;</i>Cash Book</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_account_general_ledger_search')}}"><i class="material-icons">&#xE315;</i>General Ledger</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_account_trial_balance_search')}}"><i class="material-icons">&#xE315;</i>Trial Balance</a></span>
                            </div>
                        </li>

                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href=""><i class="material-icons">&#xE315;</i>Income Statement</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_account_balance_and_sheet')}}"><i class="material-icons">&#xE315;</i>Balance Sheet</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_account_cash_flow_statement')}}"><i class="material-icons">&#xE315;</i>Cash Flow </a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{route('report_account_transactions')}}"><i class="material-icons">&#xE315;</i>Account Transactions</a></span>
                            </div>
                        </li>
                    </ul>

                    <h5><strong>Purchase</strong></h5>

                    <ul class="md-list">
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('purchase_report') }}"><i class="material-icons">&#xE315;</i>Purchase Report</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('undelivered_report') }}"><i class="material-icons">&#xE315;</i>Undelivered Products</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('report_special_offer') }}"><i class="material-icons">&#xE315;</i>Special Offer</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href=""><i class="material-icons">&#xE315;</i>Company Status</a></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="uk-width-large-1-2 uk-width-medium-1-2">

                    <h5><strong>Sales</strong></h5>

                    <ul class="md-list">
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('sales_report') }}"><i class="material-icons">&#xE315;</i>Sales Report</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('sales_return_report') }}"><i class="material-icons">&#xE315;</i>Sales Return</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('customer_wise_report') }}"><i class="material-icons">&#xE315;</i>Customerwise Report</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('sales_summary') }}"><i class="material-icons">&#xE315;</i>Sales Summary</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('outlet_record') }}"><i class="material-icons">&#xE315;</i>Outlet Record</a></span>
                            </div>
                        </li>
                    </ul>

                    <h5><strong>Stock</strong></h5>

                    <ul class="md-list">
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('stock_report') }}"><i class="material-icons">&#xE315;</i>Stock Reports</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('damage_report') }}"><i class="material-icons">&#xE315;</i>Damage Details</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('free_details_report') }}"><i class="material-icons">&#xE315;</i>Free Details</a></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content reports_list">
                                <span class="md-list-heading"><a href="{{ route('report_product_list') }}"><i class="material-icons">&#xE315;</i>Product List</a></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">

        var list                = {};
        var contact_wise_list   = {};

        $("form").submit(function() {
            $("form").attr('target', '_blank');
            return true;
        });

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');

        var display_name_url                = "{{ route("report_account_contact_list_apiContactName_by_search") }}";
        var display_contact_wise_name_url   = "{{ route("report_account_contactwise_api_list_alpha_name_search") }}";
        var list_url                        = "{{ route("report_account_contact_list_contact_by_search") }}";

        $("body").on("click",function () {
           $("#myUL").empty();
           $("#myUL_contact_wise").empty();
           list={};
           contact_wise_list={};
        });

        $("#contact_name_search").on("input keyup",function () {

            var contact_name = $(this).val().trim();
            $("#myUL").empty();

            if(contact_name.length > 1){

                $.get(display_name_url, {"name":contact_name}, function (options) {

                    list = options;

                    if($('#myUL li').length == 0){

                        $.each(list, function(index, data) {
                            $("#myUL").append($("<li>", {}).prepend($("<a>", { href: data.url,'target':'_blank' }).text(data.display_name)));
                        });

                    }

                });
            }
        });

        $("#contactwise_name_search").on("input keyup",function () {
            var contactwise_name=$(this).val().trim();
            $("#myUL_contact_wise").empty();

            if(contactwise_name.length>2){

                $.get(display_contact_wise_name_url,{"name":contactwise_name},function (options) {
                    contact_wise_list = options;
                });

                $.each(contact_wise_list, function(index,data) {
                    $("#myUL_contact_wise").append($("<li>", {}).prepend($("<a>", { href: data.url,'target':'_blank' }).text(data.display_name)));
                });
            }
        });

    </script>

@endsection