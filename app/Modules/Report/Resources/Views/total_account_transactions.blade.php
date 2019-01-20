@extends('layouts.admin')

@section('title', 'Total Account Transaction '.date("Y-m-d h-i-sa"))

@section('header')

    @include('inc.header')
@endsection

@section('sidebar')

    @include('inc.sidebar')
@endsection

@section('styles')
    <style>
        table.due {
            border: .5px solid black !important;
            width: 100%;
        }
        .due tr td{
            vertical-align:middle;
            border: .2px solid gainsboro;
        }
        @media print
        {
            .md-card-toolbar{
                display: none;
            }
            table#profit tr td,table#profit tr th{
                font-size: 11px !important;
            }
            .uk-table tr td{
                padding: 5px 5px;
                border: 1px solid black !important;
                font-size: 11px !important;
            }
            .uk-table tr th{
                padding: 5px 5px;
                border: 1px solid black;
                /*border-bottom: 1px solid black;*/
                font-size: 11px !important;
            }
            .uk-table>tbody>tr:last-child td{
                border: none !important;
            }
            @page {size: A4; margin:2mm;}
            body{
                margin-top: -40px;
            }
        }
    </style>
@endsection

@section('content_header')
    <div id="top_bar">
        <div class="md-top-bar">
            <ul class="uk-clearfix" id="menu_top">
                <li class="uk-hidden-small" data-uk-dropdown="">
                    <a href="#">
                        <i class="material-icons">
                            
                        </i>
                        <span>
                            Reports
                        </span>
                    </a>
                    <div class="uk-dropdown">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li>
                                Business Overview
                            </li>
                            <li>
                                <a href="{{route('report_account_profit_loss')}}">
                                    Profit and Loss
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_cash_flow_statement')}}">
                                    Cash Flow Statement
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_balance_sheet')}}">
                                    Balance Sheet
                                </a>
                            </li>
                            <li>
                                Accountant
                            </li>
                            <li>
                                <a href="{{route('report_account_transactions')}}">
                                    Account Transactions
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_general_ledger_search')}}">
                                    General Ledger
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_journal_search')}}">
                                    Journal Report
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_trial_balance_search')}}">
                                    Trial Balance
                                </a>
                            </li>
                            <li>
                                Sales
                            </li>
                            <li>
                                <a href="{{route('report_account_customer')}}">
                                    Sales by Customer
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Sales by Item
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_item')}}">
                                    Product Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="uk-width-medium-10-10 uk-container-center reset-print">
        <div class="uk-grid uk-grid-collapse" data-uk-grid-margin="">
            <div class="uk-width-large-10-10">
                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions hidden-print">
                                <i class="md-icon material-icons" id="invoice_print">
                                    
                                </i>
                                <!--end  -->
                                <div aria-expanded="true" aria-haspopup="true" class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                    <a data-uk-modal="{target:'#coustom_setting_modal'}" href="#">
                                        <i class="material-icons">
                                            
                                        </i>
                                        <span>
                                            Custom Setting
                                        </span>
                                    </a>
                                </div>
                                <!--coustorm setting modal start -->
                                <div class="uk-modal" id="coustom_setting_modal">
                                    <div class="uk-modal-dialog">
                                        {!! Form::open(['url' => route("account_report_total_transaction_index_data_filter"), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">
                                                Select Date Range and Transaction Type
                                                <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">
                                                    
                                                </i>
                                            </h3>
                                        </div>
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            @if(Auth::user()->branch_id==1)
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <label for="branch_id" style="margin-left: 10px;">
                                                        Branch
                                                    </label>
                                                    <select id="branch_id" name="branch_id" style="padding: 5px; border-top:none; border-left:none; border-right:none; border-bottom:1px solid lightgray">
                                                        <!-- <option value="">Account</option> -->
                                                        @foreach($branch as $branch_data)
                                                        <option style="z-index: 10002" value="{{$branch_data->id}}">
                                                            {{$branch_data->branch_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="uk-input-group-icon uk-icon-calendar">
                                                        </i>
                                                    </span>
                                                    <label for="uk_dp_1">
                                                        From
                                                    </label>
                                                    <input class="md-input" data-uk-datepicker="{format:'DD.MM.YYYY'}" id="uk_dp_1" name="from_date" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="uk-input-group-icon uk-icon-calendar">
                                                        </i>
                                                    </span>
                                                    <label for="uk_dp_1">
                                                        To
                                                    </label>
                                                    <input class="md-input" data-uk-datepicker="{format:'DD.MM.YYYY'}" id="uk_dp_1" name="to_date" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button class="md-btn md-btn-flat uk-modal-close" type="button">
                                                Close
                                            </button>
                                            <button class="md-btn md-btn-flat md-btn-flat-primary" name="submit" type="submit">
                                                Search
                                            </button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <!--end  -->
                            </div>
                            <h3 class="md-card-toolbar-heading-text large" id="invoice_name">
                            </h3>
                        </div>
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img alt="" class="logo_regular" height="15" src="{{ url('uploads/op-logo/logo.png') }}" style="margin-bottom: -20px;" width="71"/>
                                    <p class="uk-text-large" style="line-height: 5px; margin-top: 35px;">
                                        {{ $OrganizationProfile->company_name }}
                                    </p>
                                    <p class="heading_b" style="line-height: 5px;">
                                        Transactions Report
                                    </p>
                                    @if(isset($branch_id))
                                    <p>
                                        @foreach($branch as $branchs) @if($branchs->id==$branch_id) {{$branchs->branch_name}} @endif @endforeach
                                    </p>
                                    @endif
                                    <p class="uk-text-small" style="line-height: 5px;">
                                        From {{ date('d-m-Y',strtotime($start)) }} To {{ date("d-m-Y",strtotime($end."-0 days"))}}
                                    </p>
                                </div>
                            </div>
                            <div class="uk-grid uk-margin-large-bottom">
                                <div class="uk-width-1-1">
                                    <table class="uk-table total_transaction">
                                        <thead>
                                            <tr class="uk-text-upper">
                                                <th class="uk-text-left">
                                                    Transaction
                                                </th>
                                                <th class="uk-text-left">
                                                    Particulars
                                                </th>
                                                <th class="uk-text-right">
                                                    Purchase
                                                </th>
                                                <th class="uk-text-right">
                                                    Sales
                                                </th>
                                                <th class="uk-text-right">
                                                    General Expense
                                                </th>
                                                <th class="uk-text-right">
                                                    Receipt
                                                </th>
                                                <th class="uk-text-right">
                                                    Payment
                                                </th>
                                            </tr>
                                        </thead>

                                        @php
                                            $k=0;
                                            $m=0;
                                            $n=0;
                                            $total_purchase = 0;
                                            $total_sales = 0;
                                            $total_generalExpense = 0;
                                            $total_sales_commission = 0;
                                            $total_receipt = 0;
                                            $total_income = 0;
                                            $total_payments = 0;
                                            $total_payments_12 = 0;
                                            $total_due = 0;
                                        @endphp

                                        <tbody>
                                            <tr style="color: #16a085">
                                                <td class="uk-text-left">
                                                </td>
                                                <td class="uk-text-left">
                                                    Opening Balance
                                                </td>
                                                <td class="uk-text-right">
                                                    {{$journal['openingBalance']['openingPurchase']}} 
                                                    
                                                </td>
                                                <td class="uk-text-right">
                                                    {{$journal['openingBalance']['openingSales']}}
                                                     
                                                </td>
                                                <td class="uk-text-right">
                                                    {{$journal['openingBalance']['openingGeneralExpense']}}
                                                     
                                                </td>
                                                <td class="uk-text-right">
                                                    {{$journal['openingBalance']['openingReceipt']}}
                                                   

                                                </td>
                                                <td class="uk-text-right">
                                                    {{$journal['openingBalance']['openingPayments']}}

                                                    
                                                </td>
                                            </tr>

                                            <tr>
                                                @foreach($journal as $type=>$item)
                                                    @if($type != "totalDue" && $type != "invoiceDue" && $type != "billDue" && $type != "totalSales" && $type != "totalPurchase" && $type != "openingBalance")
                                                        @if(is_array($item))
                                                            @foreach($item as $value)
                                                                <tr>
                                                                    <td class="uk-text-left">

                                                                        {{ isset($value["transaction"])? $value["transaction"] : "" }}
                                                                    </td>
                                                                    <td class="uk-text-left" style="text-align: justify !important;">
                                                                        {{ isset($value["display_name"])? $value["display_name"] : "" }}
                                                                        
                                                                        @if(isset($value["adjustments"]))
                                                                            <br/>
                                                                            @php
                                                                                echo $value["adjustments"];
                                                                            @endphp
                                                                        @endif

                                                                        @if(!empty($value["items"]))
                                                                            <br/>
                                                                            ( {!! $value["items"] !!} )
                                                                        @endif
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                        @if($type=="purchase")
                                                                            @php
                                                                                $total_purchase+=$value["amount"];
                                                                            @endphp
                                                                            {{ $value["amount"] }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                        @if($type=="sales")
                                                                            
                                                                            @php
                                                                                $total_sales+=$value["amount"];
                                                                            @endphp
                                                                            
                                                                            @if(isset($value["amount_string"]))
                                                                                @php
                                                                                    echo $value["amount_string"];
                                                                                @endphp
                                                                            @endif

                                                                            {{ $value["amount"] }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                        @if($type=="expenseAndCommission")
                                                                            @php
                                                                                $total_generalExpense+=$value["amount"];
                                                                            @endphp
                                                                            {{ $value["amount"] }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                        @if($type=="receiptAndIncome" || $type=="bank")
                                                                            @if(isset($value["debit_credit"]))
                                                                                @if($value["debit_credit"] == 0)
                                                                                    @php
                                                                                        $total_receipt+=$value["amount"];
                                                                                    @endphp
                                                                                    {{ $value["amount"] }}
                                                                                @endif
                                                                            @else
                                                                                @php
                                                                                    $total_receipt+=$value["amount"];
                                                                                @endphp
                                                                                {{ $value["amount"] }}
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                        @if($type=="payment" || $type=="bank")
                                                                            @if(isset($value["debit_credit"]))
                                                                                @if($value["debit_credit"] == 1)
                                                                                    @php
                                                                                        $total_payments+=$value["amount"];
                                                                                    @endphp
                                                                                    {{ $value["amount"] }}
                                                                                @endif
                                                                            @else
                                                                                @php
                                                                                    $total_payments+=$value["amount"];
                                                                                @endphp
                                                                                {{ $value["amount"] }}
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    {{-- total_due amount --}}
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach

                                                <tr style="color: #16a085">
                                                    <td class="uk-text-left">
                                                    </td>
                                                    <td class="uk-text-right">
                                                        Total
                                                    </td>
                                                    <td class="uk-text-right">
                                                        {{ $total_purchase }}
                                                    </td>
                                                    <td class="uk-text-right">
                                                        {{ $total_sales }}
                                                    </td>
                                                    <td class="uk-text-right">
                                                        {{ number_format(($total_generalExpense),2,'.','') }}
                                                    </td>
                                                    <td class="uk-text-right">
                                                        {{ number_format(($total_receipt),2,'.','') }}
                                                    </td>
                                                    <td class="uk-text-right">
                                                        {{ number_format(($total_payments),2,'.','') }}
                                                    </td>
                                                </tr>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr/>
                            <div class="uk-grid uk-margin-large-bottom">
                                <div class="uk-width-1-1">
                                    <table cellpadding="8" cellspacing="0" class="due br">
                                        <tbody>
                                            <tr>
                                                <td rowspan="2">
                                                    Total Sales
                                                </td>
                                                <td rowspan="2">
                                                    {{ number_format(($journal["totalSales"]),2,'.','') }}
                                                </td>
                                                <td rowspan="2">
                                                    Total Purchase
                                                </td>
                                                <td rowspan="2">
                                                    {{ number_format(($journal["totalPurchase"]),2,'.','') }}
                                                </td>
                                                <td>
                                                    Total Sales Due
                                                </td>
                                                <td>
                                                    {{ number_format(($journal["invoiceDue"]),2,'.','') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Total Purchase Due
                                                </td>
                                                <td>
                                                    {{ number_format(($journal["billDue"]),2,'.','') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <span class="uk-text-muted uk-text-small uk-text-italic">
                                        Notes:
                                    </span>
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
    <script src="{{ url('admin/bower_components/handlebars/handlebars.min.js')}}">
    </script>
    <script src="{{ url('admin/assets/js/custom/handlebars_helpers.min.js')}}">
    </script>
    <!--  invoices functions -->
    <script src="{{ url('admin/assets/js/pages/page_invoices.min.js')}}">
    </script>
    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
    $('#sidebar_reports').addClass('act_item');
    </script>
@endsection
