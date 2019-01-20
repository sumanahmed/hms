@extends('layouts.admin')

@section('title', 'Cash Book '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('styles')
    <style>
        #list_table_right tr td:nth-child(1) {

            white-space: nowrap;
        }

        #list_table_left, #list_table_right {
            width: 100%;
            padding: 10px;

        }

        #list_table_left tr td, #list_table_right tr td {
            text-align: center;
            padding-left: 3px;
            padding-right: 3px;
        }

        #list_table_left tr th, #list_table_right tr th {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            font-size: 10px;
        }

        #list_table_left tr td:nth-child(1), #list_table_left tr td:last-child, #list_table_left tr th:last-child, #list_table_right tr td:last-child {

            white-space: nowrap;
        }

        @media print {
            #list_table_left tr td, #list_table_right tr td {
                border: 1px solid black;
                padding-left: 3px;
                padding-right: 3px;

            }

            #list_table_right_parent tr th, #list_table_left_parent tr th {
                border: 1px solid black;
            }

            #list_table_right_parent, #list_table_left_parent, #list_table_left, #list_table_right {

                font-size: 11px !important;
                border-spacing: 0px;
                border-collapse: collapse;

            }

            #list_table_right {
                margin-left: 10px;
            }

            body {
                margin-top: -40px;
            }

            #total, #table_close, #table_open, #list_table_left, #list_table_right {
                font-size: 11px !important;
            }

            .md-card-toolbar {
                display: none;
            }

            #list_table_left tr th:nth-child(5) {
                display: none;
            }

            #list_table_right tr th:nth-child(5) {
                display: none;
            }

            #list_table_left tr td:nth-child(5) {
                display: none;
            }

            #list_table_right tr td:nth-child(5) {
                display: none;
            }

        }
    </style>
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content_header')
    <div id="top_bar" class="hidden-print">
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
        <div class="uk-grid uk-grid-collapse">
            <div class="uk-width-large-10-10">
                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview hidden-print">
                        <div class="md-card-toolbar hidden-print">
                            <div class="md-card-toolbar-actions hidden-print">
                                <i class="md-icon material-icons" id="invoice_print"></i>


                                <!--end  -->
                                <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}"
                                     aria-haspopup="true" aria-expanded="true"><a href="#"
                                                                                  data-uk-modal="{target:'#coustom_setting_modal'}"><i
                                                class="material-icons">&#xE8B8;</i><span>Custom Setting</span></a>

                                </div>
                                <!--coustorm setting modal start -->
                                <div class="uk-modal" id="coustom_setting_modal">
                                    <div class="uk-modal-dialog">
                                        {!! Form::open(['url' => 'report/cashbook', 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">Select Date Range and Transaction Type <i
                                                        class="material-icons" data-uk-tooltip="{pos:'top'}"
                                                        title="headline tooltip">&#xE8FD;</i></h3>
                                        </div>

                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i
                                                                class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">From</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="from_date"
                                                           data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i
                                                                class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">To</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="to_date"
                                                           data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close
                                            </button>
                                            <button type="submit" name="submit"
                                                    class="md-btn md-btn-flat md-btn-flat-primary">Search
                                            </button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <!--end  -->
                            </div>

                            <h3 class="md-card-toolbar-heading-text large" id="invoice_name"></h3>
                        </div>
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">

                            <div class="uk-grid" data-uk-grid-margin="">

                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img style="margin-bottom: -20px;" class="logo_regular"
                                         src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                    <p style="line-height: 5px; margin-top: 35px;"
                                       class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                    <p style="line-height: 5px;" class="heading_b">Cash Book</p>
                                    <p style="line-height: 5px;" class="uk-text-small">From {{$start}} To {{$end}}</p>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-2">
                                </div>
                                <div class="uk-width-1-2">
                                </div>

                                <!-- Debit Calculation-->
                                <div id="list_table_left_parent" class="uk-width-1-2" style="font-size: 12px;">

                                    <table id="list_table_left">

                                        <thead>
                                            <tr class="uk-text-upper">
                                                <th style="font-size: 10px">DATE</th>
                                                <th style="font-size: 10px">Particulars</th>
                                                <th style="font-size: 10px" class="uk-text-center">DEBIT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php
                                                $debit = 0;
                                                $credit = 0;
                                            ?>

                                            <tr>
                                                <td></td>
                                                <td class="uk-text-right"><strong>Opening Balance</strong></td>
                                                <td class="uk-text-right">
                                                    <strong>
                                                        @if($total_cash_inhand > 0)
                                                            {{$total_cash_inhand}}
                                                        @elseif($total_cash_inhand < 0)
                                                            ({{abs($total_cash_inhand)}})
                                                        @endif
                                                    </strong>
                                                </td>

                                            </tr>
                                            @foreach($JournalEntrys as $JournalEntryData)
                                                @if($JournalEntryData->debit_credit == 1)

                                                    <tr class="uk-table-middle">

                                                        <td class="uk-text-left"> {{ date('d-m-Y',strtotime($JournalEntryData->assign_date)) }} </td>

                                                        <td class="uk-text-left">

                                                                @if($JournalEntryData->jurnal_type == "bank")

                                                                 {{  $JournalEntryData->bank->account->account_name }}
                                                                 ( {{ $JournalEntryData->bank->particulars }} )

                                                                @elseif($JournalEntryData->jurnal_type == "income")

                                                                    Income for {{ $JournalEntryData->income->account->account_name }} from {{ $JournalEntryData->contact->display_name }}


                                                                @elseif($JournalEntryData->jurnal_type == "expense")

                                                                    Expense from {{ $JournalEntryData->expense->account->account_name }} for {{ $JournalEntryData->contact->display_name }}


                                                                @elseif($JournalEntryData->jurnal_type == "payment_receive2")

                                                                    Bill Payment From {{ $JournalEntryData->contact->display_name }}

                                                                @endif

                                                        </td>                                                       

                                                        <td class="uk-text-right">

                                                            @if($JournalEntryData->debit_credit == 1)

                                                                {{$JournalEntryData->amount}}

                                                                <?php
                                                                    $debit = $debit + $JournalEntryData->amount;
                                                                ?>

                                                            @endif

                                                        </td>

                                                    </tr>

                                                @endif
                                            @endforeach

                                            <tr class="uk-table-middle">
                                                <td class="uk-text-right" colspan="2">     
                                                    <strong>Total</strong>
                                                </td>                                                       
                                                <td class="uk-text-right">
                                                    <strong> {{$debit + $total_cash_inhand}} </strong>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                                <!-- Credit Calculation-->
                                <div id="list_table_right_parent" class="uk-width-1-2" style="font-size:12px;">
                                    <table id="list_table_right">

                                        <thead>
                                            <tr class="uk-text-upper">
                                                <th style="font-size: 10px">DATE</th>
                                                <th style="font-size: 10px">Particulars</th>
                                                <th style="font-size: 10px" class="">CREDIT</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($JournalEntrys as $JournalEntryData)
                                                @if($JournalEntryData->debit_credit == 0)

                                                    <tr class="uk-table-middle">

                                                        <td class="uk-text-left">{{ date('d-m-Y',strtotime($JournalEntryData->assign_date)) }}</td>
                                                        <td class="uk-text-left">
                                                           
                                                                @if($JournalEntryData->jurnal_type == "bank")

                                                                    {{  $JournalEntryData->bank->account->account_name }}
                                                                    ( {{ $JournalEntryData->bank->particulars }} )

                                                                @elseif($JournalEntryData->jurnal_type == "expense")

                                                                    {{ $JournalEntryData->expense->account->account_name }} to {{ $JournalEntryData->contact->display_name }}


                                                                @elseif($JournalEntryData->jurnal_type == "income")

                                                                    {{ $JournalEntryData->income->account->account_name }} from {{ $JournalEntryData->contact->display_name }}

                                                                @elseif($JournalEntryData->jurnal_type == "payment_made2")

                                                                    Purchase Payment to {{ $JournalEntryData->contact->display_name }}

                                                                @elseif($JournalEntryData->jurnal_type == "sales_commission")

                                                                    Sales Commission to {{ $JournalEntryData->agent->display_name }}

                                                                @elseif($JournalEntryData->jurnal_type == "12")

                                                                    Customer Refund to {{ $JournalEntryData->contact->display_name }}

                                                                @endif

                                                        </td>

                                                        <td class="uk-text-right">
                                                            @if($JournalEntryData->debit_credit == 0)
                                                                {{$JournalEntryData->amount}}
                                                                <?php
                                                                    $credit = $credit + $JournalEntryData->amount;
                                                                ?>
                                                            @endif
                                                        </td>

                                                    </tr>

                                                @endif
                                            @endforeach

                                            <tr>
                                                <td></td>

                                                <td class="uk-text-right"><strong>Cash In Hand</strong></td>

                                                <td class="uk-text-right">
                                                    <strong>
                                                        <?php $ccih = $current_cash_in_hand ?>

                                                        @if($ccih > 0)
                                                            {{$ccih}}
                                                        @elseif($ccih < 0)
                                                            ({{abs($ccih)}})
                                                        @endif
                                                    </strong>
                                                </td>
                                            </tr>

                                            <tr class="uk-table-middle">
                                                <td class="uk-text-right" colspan="2">     
                                                    <strong> Total </strong>
                                                </td>                                                       
                                                <td class="uk-text-right">
                                                    <strong> {{ $credit + $current_cash_in_hand }} </strong>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>


                            </div>
                            <div class="uk-grid">

                                <span class="uk-text-muted uk-text-small uk-text-italic">Notes:</span>
                                <p class="uk-text-small"></p>

                            </div>


                            <div class="uk-grid">
                                <div class="uk-width-1-2" style="text-align: left">
                                    <p class="uk-text-small uk-margin-bottom">Accounts Signature</p>
                                </div>
                                <div class="uk-width-1-2" style="text-align: right">
                                    <p class="uk-text-small uk-margin-bottom">Authorized Signature</p>
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

        $("#invoice_print").click(function () {
            $("#list_table_right").removeClass('uk_table');
            $("#list_table_left").removeClass('uk_table');
        });

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');

    </script>
@endsection
