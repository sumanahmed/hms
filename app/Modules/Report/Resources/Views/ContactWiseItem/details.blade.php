@extends('layouts.invoice')

@section('title', 'Products Sold Report details '.date("Y-m-d h-i-sa"))

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
                content: "" !important;
            }

            a {
                text-decoration: none;
            }

            .uk-table {
                border: 1px solid black;
            }

            .uk-table tr td {
                white-space: nowrap;
                padding: 5px 5px;
                border: 1px solid black;
                width: 100%;
                font-size: 11px !important;
            }

            .uk-table tr td:first-child, .uk-table tr th:first-child {
                text-align: left !important;
                width: 10% !important;
            }

            .uk-table tr th, .uk-table:last-child tr td {

                white-space: nowrap;
                padding: 3px 5px;
                border: 1px solid black;

                width: 100%;
                font-size: 11px !important;
            }

            body {
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
                    <div class="md-card-toolbar hidden-print">
                        <div class="md-card-toolbar-actions hidden-print" style="width: 100%">
                            <i class="md-icon material-icons" id="invoice_print">
                                
                            </i>
                         
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
                            <!--custom setting modal start -->
                            <div class="uk-modal" id="coustom_setting_modal">
                                <div class="uk-modal-dialog">
                                    {!! Form::open([ 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">
                                            Select Date Range and Transaction Type
                                            <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">
                                                
                                            </i>
                                        </h3>
                                    </div>
                                    <div class="uk-width-large-2-2 uk-width-2-2">
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-input-group">
                                                <span class="uk-input-group-addon">
                                                    <i class="uk-input-group-icon uk-icon-calendar">
                                                    </i>
                                                </span>
                                                <label for="uk_dp_1">
                                                    Form
                                                </label>
                                                <input class="md-input" data-uk-datepicker="{format:'YYYY-MM-DD'}" id="uk_dp_1" name="from_date" type="text">
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
                                                <input class="md-input" data-uk-datepicker="{format:'YYYY-MM-DD'}" id="uk_dp_1" name="to_date" type="text">
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
                        
                    </div>
                    <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                        <div class="uk-grid">
                            <div class="uk-width-small-5-5 uk-text-center">
                                <img alt="" class="logo_regular" height="15" src="{{ url('uploads/op-logo/logo.png') }}" style="margin-bottom: -20px;" width="71"/>
                                <p class="uk-text-large" style="line-height: 6px; margin-top: 35px;">
                                    {{ $OrganizationProfile->company_name }}
                                </p>
                                <p class="heading_b" style="line-height: 20px;">
                                    Items Sold/Purchased by {{$name}}
                                </p>
                                @if(isset($start) && isset($end))
                                <p style="line-height: 6px;">
                                    {{ $start. " to ". $end }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <table class="uk-table" id="contact_filter_table">
                                    <thead>
                                        <tr class="uk-text-upper">
                                            <th class="uk-text-left">
                                                Date
                                            </th>
                                            <th class="uk-text-right">
                                                Transaction Number
                                            </th>
                                            <th class="uk-text-right">
                                                Item Name
                                            </th>
                                            <th class="uk-text-right">
                                                Rate
                                            </th>
                                            <th class="uk-text-right">
                                                Sales Quantity
                                            </th>
                                            <th class="uk-text-right">
                                                Purchases Quantity
                                            </th>
                                            <th class="uk-text-right">
                                                Rate
                                            </th>
                                            <th class="uk-text-right">
                                                Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortbyalpa">
                                        @php $total_sales=0; $total_purchase=0;@endphp
                                        @foreach($data as $item)
                                        <tr class="uk-text-upper">
                                            <td class="uk-text-left">
                                                {{date('Y-m-d', strtotime( $item['date'])) }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['transaction_number'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['item_name'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['rate'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['sales_quantity'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['purchase_quantity'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{ $item['rate'] }}
                                            </td>
                                            <td class="uk-text-right">
                                                {{number_format($item['amount'], 2)}}
                                            </td>
                                            @php
                                                if(isset($item['sales_quantity']))$total_sales+=$item['amount'];
                                                else $total_purchase+=$item['amount'];
                                                
                                                @endphp
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                            </td><td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td class="uk-text-right">
                                                <b>
                                                    Total Sales
                                                </b>
                                            </td>
                                            <td class="uk-text-right">
                                                {{number_format($total_sales, 2)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td><td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td class="uk-text-right">
                                                <b>
                                                    Total Purchase
                                                </b>
                                            </td>
                                            <td class="uk-text-right">
                                                {{number_format($total_purchase, 2)}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
<script type="text/javascript">
    $('#sidebar_reports').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');
</script>
@endsection
