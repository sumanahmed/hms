@extends('layouts.invoice')

@section('title', 'Contact Details Report '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('styles')
    <style>
        .update-picker-year option,.update-picker-month option{
          color:black !important;
          background: white; !important;

        }

        @media print {
            a[href]:after {
                content:"" !important;

            }
            a{
                text-decoration: none;
            }
            #group_pr {
                background-color: #e1e1e1 !important;
                color: black !important;
                font-size: 14px !important;
            }
            table.uk-table {
                margin-top: -20px;
                width: 100% !important;
            }
            .uk-table tr td{

              padding: 1px 0px;
              border: 1px solid black !important;

              font-size: 11px !important;

          }
          .uk-table tr th{
            border: 1px solid black !important;
            vertical-align: middle;
          }
          .uk-table tr td:first-child,.uk-table tr th:first-child{
            text-align: left !important;

        }
        .uk-table tr th ,.uk-table:last-child tr td{


            padding: 1px 5px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;

            font-size: 11px !important;
        }
        .uk-table tr th:nth-child(3){
            width: 18% !important;


        }
        body{
            margin-top: -50px;
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

                            <div class="md-card-toolbar-actions hidden-print">

                                <div  style="float: left; margin-right: 10px;" data-uk-button-radio="{target:'.lg-btn'}">

                                    @if($groupbytype != 1)
                                        @if(isset($account_name))
                                            <select id="account_filter_dropbox" name ="account_filter_dropbox" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Filter By Account">
                                                <option value="">Filter by Account</option>
                                                <option value="all">All</option>
                                                 @foreach($account_name as $item)
                                                    <option value="{{ $item[0]['account_id'] }}">{{ $item[0]['account_name'] }}</option>
                                                 @endforeach
                                            </select>
                                        @endif
                                    @endif

                                </div>

                                <div  style="float: left; " data-uk-button-radio="{target:'.md-btn'}">
                                    <a  href="?group=true" style="color:white ; background-color: #7cb342;" class="md-btn md-btn-wave ">Transaction wise</a>
                                    <a href="?flat=true" style="color:white; background-color: #7cb342;" class="md-btn md-btn-wave ">Date wise</a>

                                </div>
                                <i class="md-icon material-icons" id="invoice_print">print</i>
                                <a href="{{ route('report_mail_send_view',['id'=>$id, 'branch'=>$current_branch, 'start'=>$start, 'end'=>$end, 'display_name'=>$OrganizationProfile->company_name ]) }}"><i class="material-icons">&#xE0BE;</i></a>
                                <!--end  -->
                                <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}" aria-haspopup="true" aria-expanded="true"> <a href="#" data-uk-modal="{target:'#coustom_setting_modal'}"><i class="material-icons">&#xE8B8;</i><span>Custom Setting</span></a>

                                </div>
                                <!--coustorm setting modal start -->
                                <div class="uk-modal" id="coustom_setting_modal">
                                    <div class="uk-modal-dialog">
                                        {!! Form::open(['url' => route('report_account_single_contact_details_by_date',$id), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">Select Date Range and Transaction Type <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="Select Date Range and Transaction Type">&#xE8FD;</i></h3>
                                        </div>


                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">From</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="from_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">To</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="to_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
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
                                    <p style="line-height: 5px;" class="heading_b">{{ $customer['display_name'] }} Report Details</p>
                                    <p style="line-height: 5px;">{{ $current_branch['branch_name'] }}</p>

                                    <p style="line-height: 10px;"> {{ $start." ". " to " ." $end" }} </p>
                                </div>
                            </div>

                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <table id="account_filter_table" class="uk-table">

                                        <thead>
                                            <tr style="border-bottom: 1px solid white " class="uk-text-middle">
                                                <th class="uk-text-left" style="width: 0%; vertical-align: top; display: none;">Account ID</th>
                                                <th class="uk-text-left" style="width: 15%; vertical-align: top;">Date</th>
                                                <th class="uk-text-left" style="width: 10%; vertical-align: top;">Transaction ID</th>
                                                <th class="uk-text-left" style="width: 35%; vertical-align: top;">Particulars</th>
                                                <th class="uk-text-left" style="width: 5%; vertical-align: top;">Quantity</th>
                                                <th class="uk-text-right" style="width: 10%;">Debit (Receivables/Payments)</th>
                                                <th class="uk-text-right" style="width: 10%;">Credit (Payables/Receipts)</th>
                                                <th class="uk-text-right" style="width: 15%; vertical-align: top;">Balance</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $total_purchase = 0;
                                                $balance = $openning_balance['dr'] - $openning_balance['cr'];
                                            @endphp

                                            <tr style="border-bottom: 0px solid white " class="uk-text-middle">
                                                <td class="uk-text-left" style="display: none;"></td>
                                                <td class="uk-text-left">{{ date("d-m-Y",strtotime($start)) }}</td>
                                                <td class="uk-text-left"></td>
                                                <td class="uk-text-left">Opening Balance</td>
                                                <td class="uk-text-left">  </td>
                                                <td class="uk-text-right">{{ number_format((float)$openning_balance['dr'], 2, '.', '') }}</td>
                                                <td class="uk-text-right">{{ number_format((float)$openning_balance['cr'], 2, '.', '') }}</td>
                                                <td class="uk-text-right">{{ number_format((float)$balance, 2, '.', '') }}</td>
                                            </tr>

                                            @if($groupbytype == 1)

                                                @foreach($list as $key =>$type)

                                                    @php
                                                        $type = $type->sortBy('jurnal_type');
                                                    @endphp

                                                    @if($key!="invoice")

                                                        <tr id="{{ $key }}" class="md-bg-grey-300" style="color: black;padding-top:10px; " class="uk-table-middle">
                                                            <td style="text-transform: uppercase " id="group_pr" title="{{ $key }}" colspan="7" class="uk-text-left"> {{ $key }} </td>
                                                        </tr>

                                                        @foreach($type as $contact)

                                                            <tr class="uk-table-middle">
                                                                <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                                <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                <td class="uk-text-left"> {{ $contact['transectionid'] }} </td>

                                                                @if($contact['jurnal_type'] == "bill")

                                                                    @php
                                                                        $particular_array = explode(',', $contact['particularsname']);
                                                                        $quantity_array = explode(',', $contact['quantity']);
                                                                    @endphp

                                                                    @if(is_array($particular_array) && is_array($quantity_array))

                                                                        <td class="uk-text-left">
                                                                            @for($i = 0; $i < count($particular_array); $i++)
                                                                                {{ $particular_array[$i] }}<br/>
                                                                            @endfor
                                                                        </td>
                                                                        <td class="uk-text-left">
                                                                            @for($i = 0; $i < count($quantity_array); $i++)
                                                                                {{ $quantity_array[$i] }}<br/>
                                                                            @endfor
                                                                        </td>

                                                                    @endif

                                                                @else

                                                                <td class="uk-text-left"> {{ $contact['particularsname'] }} </td>
                                                                <td class="uk-text-left"> {{ $contact['quantity'] }} </td>

                                                            @endif

                                                            <td class="uk-text-right">
                                                                @if($contact['jurnal_type']=="payment_made2"||$contact['jurnal_type']=="credit note refund")
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="bank" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="expense"&&$contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="journal"&& $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{  number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="sales_commission"&&$contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="income" &&$contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                {{--@if($contact['jurnal_type']=="invoice"&&$contact['account_namead_id']==21)--}}
                                                                {{--{{ number_format((float)$contact['amount'], 2, '.', '') }}--}}
                                                                {{--@endif--}}
                                                            </td>
                                                            <td class="uk-text-right">
                                                                @if($contact['jurnal_type']=="bill" || $contact['jurnal_type']=="payment_receive2"||$contact['jurnal_type']=="credit note")
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="bank" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="expense" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="journal" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="sales_commission"&&$contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                                @if($contact['jurnal_type']=="income" &&$contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                            </td>
                                                            <td class="uk-text-right"> {{ $balance }} </td>
                                                            </tr>

                                                        @endforeach

                                                    @endif

                                                    @if($key=="invoice")

                                                        <tr id="{{ $key }}" class="md-bg-grey-300" style="color: black; padding-top:10px;" class="uk-table-middle">
                                                            <td  style="text-transform: uppercase" id="group_pr"  colspan="7" class="uk-text-left"> {{ $key }} </td>
                                                        </tr>

                                                        @foreach($type as $contact)


                                                            @if($contact['account_name_id']==5)
                                                                <tr class="uk-table-middle">
                                                                 <td class="uk-text-left" style="display: none; vertical-align: top !important;">{{ $contact['account_name_id'] }}</td>
                                                                 <td class="uk-text-left" style = "vertical-align: top !important;">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                 <td class="uk-text-left" style = "vertical-align: top !important;"> {{ $contact['transectionid']  }} </td>

                                                                @php
                                                                    $particular_array = explode(',', $contact['particularsname']);
                                                                    $quantity_array = explode(',', $contact['quantity']);
                                                                @endphp

                                                                @if(is_array($particular_array) && is_array($quantity_array))

                                                                        <td class="uk-text-left" style = "vertical-align: top !important;">
                                                                            @for($i = 0; $i < count($particular_array); $i++)
                                                                                {{ $particular_array[$i] }}

                                                                                @if(isset($particular_array[$i+1]))
                                                                                    <br/>
                                                                                @endif
                                                                            @endfor
                                                                            @if($contact['vat_adjustment'])
                                                                                <br/>
                                                                                Vat Adjustment ({{ $contact['vat_adjustment'] }})
                                                                            @endif
                                                                            @if($contact['tax_adjustment'])
                                                                                <br/>
                                                                                Tax Adjustment ({{ $contact['tax_adjustment'] }})
                                                                            @endif
                                                                            @if($contact['others_adjustment'])
                                                                                <br/>
                                                                                Others Adjustment ({{ $contact['others_adjustment'] }})
                                                                            @endif
                                                                        </td>
                                                                        <td class="uk-text-left" style = "vertical-align: top !important;">
                                                                            @for($i = 0; $i < count($quantity_array); $i++)
                                                                                {{ $quantity_array[$i] }}
                                                                                <br/>
                                                                            @endfor
                                                                        </td>

                                                                @endif

                                                                 <td class="uk-text-right" style = "vertical-align: top !important;">
                                                                     @php
                                                                        $vat_adjustment = 0;
                                                                        $tax_adjustment = 0;
                                                                        $others_adjustment = 0;

                                                                        if(isset($contact['vat_adjustment']))
                                                                            $vat_adjustment = $contact['vat_adjustment'];
                                                                        if(isset($contact['tax_adjustment']))
                                                                            $tax_adjustment = $contact['tax_adjustment'];
                                                                        if(isset($contact['others_adjustment']))
                                                                            $others_adjustment = $contact['others_adjustment'];

                                                                        $balance = $balance + $contact['amount'] - ($vat_adjustment + $tax_adjustment + $others_adjustment);

                                                                        $credit = $vat_adjustment + $tax_adjustment + $others_adjustment;
                                                                     @endphp
                                                                     {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                 </td>
                                                                 <td class="uk-text-right" style = "vertical-align: bottom !important;">
                                                                    @if($credit != 0)
                                                                        {{ $credit }}
                                                                    @endif
                                                                 </td>
                                                                 <td class="uk-text-right" style = "vertical-align: bottom !important;"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                                </tr>
                                                            @endif

                                                            @if($contact['account_name_id']==21)
                                                                <tr class="uk-table-middle">
                                                                    <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                                    <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                    <td class="uk-text-left"> {{ $contact['transectionid']  }} </td>
                                                                    <td class="uk-text-left">Discount</td>
                                                                    <td></td>
                                                                    <td class="uk-text-right">
                                                                       @php
                                                                        $balance=$balance+$contact['amount'];
                                                                       @endphp
                                                                       {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                    </td>
                                                                    <td class="uk-text-right">
                                                                    </td>
                                                                    <td class="uk-text-right"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                                </tr>

                                                                <tr class="uk-table-middle">
                                                                    <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                                    <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                    <td class="uk-text-left"> {{ $contact['transectionid'] }} </td>
                                                                    <td class="uk-text-left"> Discount Adjustment</td>
                                                                    <td class="uk-text-right"></td>
                                                                    <td class="uk-text-right"></td>
                                                                    <td class="uk-text-right">
                                                                        @php
                                                                            $balance=$balance-$contact['amount'];
                                                                        @endphp
                                                                        {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                    </td>
                                                                    <td class="uk-text-right"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                                </tr>
                                                            @endif

                                                        @endforeach

                                                    @endif

                                                @endforeach

                                            @endif

                                            @if($flatrow == 1)
                                                <?php $count = 0; ?>

                                                @foreach($list as $contact)

                                                    @if($contact['jurnal_type'] != "invoice")

                                                        <tr class="uk-table-middle">
                                                            <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                            <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                            <td class="uk-text-left"> {{ $contact['transectionid'] }} </td>

                                                            @if($contact['jurnal_type'] == "bill")

                                                                @php
                                                                    $particular_array = explode(',', $contact['particularsname']);
                                                                    $quantity_array = explode(',', $contact['quantity']);
                                                                @endphp

                                                                @if(is_array($particular_array) && is_array($quantity_array))

                                                                        <td class="uk-text-left">
                                                                            @for($i = 0; $i < count($particular_array); $i++)
                                                                                {{ $particular_array[$i] }}<br/>
                                                                            @endfor
                                                                        </td>
                                                                        <td class="uk-text-left">
                                                                            @for($i = 0; $i < count($quantity_array); $i++)
                                                                                {{ $quantity_array[$i] }}<br/>
                                                                            @endfor
                                                                        </td>

                                                                @endif

                                                            @elseif($contact['jurnal_type'] == "payment_receive2")

                                                                <td class="uk-text-left">
                                                                    {{ $contact['particularsname'] }}

                                                                    @if($contact['vat_adjustment'])
                                                                        <br/>
                                                                        Vat Adjustment
                                                                    @endif
                                                                    @if($contact['tax_adjustment'])
                                                                        <br/>
                                                                        Tax Adjustment
                                                                    @endif
                                                                    @if($contact['others_adjustment'])
                                                                        <br/>
                                                                        Others Adjustment
                                                                    @endif

                                                                </td>
                                                                <td class="uk-text-left"> {{ $contact['quantity'] }} </td>

                                                            @else

                                                                <td class="uk-text-left"> {{ $contact['particularsname'] }} </td>
                                                                <td class="uk-text-left"> {{ $contact['quantity'] }} </td>

                                                            @endif

                                                            <td class="uk-text-right">
                                                                @if($contact['jurnal_type']=="payment_made2"||$contact['jurnal_type']=="credit note refund")
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="bank" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="expense" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="journal" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="sales_commission" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="income" && $contact['debit_credit']==1)
                                                                @php
                                                                $balance=$balance+$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                            </td>
                                                            <td class="uk-text-right">
                                                                @if($contact['jurnal_type']=="payment_receive2")

                                                                    @php
                                                                        $vat_adjustment = 0;
                                                                        $tax_adjustment = 0;
                                                                        $others_adjustment = 0;

                                                                        if(isset($contact['vat_adjustment']))
                                                                            $vat_adjustment = $contact['vat_adjustment'];
                                                                        if(isset($contact['tax_adjustment']))
                                                                            $tax_adjustment = $contact['tax_adjustment'];
                                                                        if(isset($contact['others_adjustment']))
                                                                            $others_adjustment = $contact['others_adjustment'];

                                                                        $balance = $balance - $contact['amount'] - ($vat_adjustment + $tax_adjustment + $others_adjustment);

                                                                        $adjustment_sum = $vat_adjustment + $tax_adjustment + $others_adjustment;
                                                                    @endphp

                                                                    {{ number_format((float)$contact['amount'], 2, '.', '') }}

                                                                    @if($contact['vat_adjustment'])
                                                                        <br/>
                                                                        {{ $vat_adjustment }}
                                                                    @endif
                                                                    @if($contact['tax_adjustment'])
                                                                        <br/>
                                                                        {{ $tax_adjustment }}
                                                                    @endif
                                                                    @if($contact['others_adjustment'])
                                                                        <br/>
                                                                        {{ $others_adjustment }}
                                                                    @endif

                                                                @endif

                                                                @if($contact['jurnal_type']=="bill" || $contact['jurnal_type']=="credit note")
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="bank" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="expense" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="journal" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="sales_commission" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif
                                                                @if($contact['jurnal_type']=="income" && $contact['debit_credit']==0)
                                                                @php
                                                                $balance=$balance-$contact['amount'];
                                                                @endphp
                                                                {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                @endif

                                                            </td>

                                                            @if($contact['jurnal_type']=="payment_receive2")
                                                                <td class="uk-text-right" style = "vertical-align: bottom !important;" > {{ number_format((float)$balance, 2, '.', '') }}</td>
                                                            @else
                                                                <td class="uk-text-right" > {{ number_format((float)$balance, 2, '.', '') }}</td>
                                                            @endif

                                                        </tr>

                                                    @endif

                                                    @if($contact['jurnal_type'] == "invoice")

                                                        @if($contact['account_name_id']==5)

                                                            <tr class="uk-table-middle">
                                                                <td class="uk-text-left" style="display: none; vertical-align: top;">{{ $contact['account_name_id'] }}</td>
                                                                <td class="uk-text-left" style = "vertical-align: top !important;">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                <td class="uk-text-left" style = "vertical-align: top !important;"> {{ $contact['transectionid'] }}</td>

                                                                @php
                                                                    $particular_array = explode(',', $contact['particularsname']);
                                                                    $quantity_array = explode(',', $contact['quantity']);
                                                                @endphp

                                                                @if(is_array($particular_array) && is_array($quantity_array))
                                                                        <td class="uk-text-left" style = "vertical-align: top !important;">
                                                                            @for($i = 0; $i < count($particular_array); $i++)
                                                                                {{ $particular_array[$i] }}

                                                                                @if(isset($particular_array[$i+1]))
                                                                                    <br/>
                                                                                @endif
                                                                            @endfor

                                                                           {{-- Disabled Adjustment Entry Show For Invoice

                                                                                 @if($contact['vat_adjustment'])
                                                                                     <br/>
                                                                                     Vat Adjustment ({{ $contact['vat_adjustment'] }})
                                                                                 @endif
                                                                                 @if($contact['tax_adjustment'])
                                                                                     <br/>
                                                                                     Tax Adjustment ({{ $contact['tax_adjustment'] }})
                                                                                 @endif
                                                                                 @if($contact['others_adjustment'])
                                                                                     <br/>
                                                                                     Others Adjustment ({{ $contact['others_adjustment'] }})
                                                                                 @endif
                                                                           --}}

                                                                        </td>
                                                                        <td class="uk-text-left" style = "vertical-align: top !important;">
                                                                            @for($i = 0; $i < count($quantity_array); $i++)
                                                                                {{ $quantity_array[$i] }}
                                                                                <br/>
                                                                            @endfor
                                                                        </td>

                                                                @endif


                                                                <td class="uk-text-right" style = "vertical-align: top !important;">
                                                                    @php
                                                                        $vat_adjustment = 0;
                                                                        $tax_adjustment = 0;
                                                                        $others_adjustment = 0;

                                                                        {{-- Disabled Adjustment Calculation

                                                                            if(isset($contact['vat_adjustment']))
                                                                                $vat_adjustment = $contact['vat_adjustment'];
                                                                            if(isset($contact['tax_adjustment']))
                                                                                $tax_adjustment = $contact['tax_adjustment'];
                                                                            if(isset($contact['others_adjustment']))
                                                                                $others_adjustment = $contact['others_adjustment'];
                                                                        --}}

                                                                        $balance = $balance + $contact['amount'] - ($vat_adjustment + $tax_adjustment + $others_adjustment);

                                                                        $credit = $vat_adjustment + $tax_adjustment + $others_adjustment;
                                                                    @endphp

                                                                    {{ number_format((float)$contact['amount'], 2, '.', '') }}
                                                                </td>
                                                                <td class="uk-text-right" style = "vertical-align: top !important;">
                                                                    @if($credit != 0)
                                                                        {{ $credit }}
                                                                    @endif
                                                                </td>
                                                                <td class="uk-text-right" style = "vertical-align: top !important;"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                            </tr>

                                                        @endif

                                                        @if($contact['account_name_id']==21)

                                                            <tr class="uk-table-middle">
                                                                <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                                <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                <td class="uk-text-left"> {{ $contact['transectionid'] }} </td>
                                                                <td class="uk-text-left">Discount</td>
                                                                <td></td>
                                                                <td class="uk-text-right">
                                                                    @php
                                                                    $balance=$balance+$contact['amount'];
                                                                    @endphp
                                                                    {{ number_format((float)$contact['amount'], 2, '.', '') }}


                                                                </td>
                                                                <td class="uk-text-right">



                                                                </td>
                                                                <td class="uk-text-right"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                            </tr>

                                                            <tr class="uk-table-middle">
                                                                <td class="uk-text-left" style="display: none;">{{ $contact['account_name_id'] }}</td>
                                                                <td class="uk-text-left">{{ date("d-m-Y",strtotime($contact['assign_date'])) }}</td>
                                                                <td class="uk-text-left"> {{ $contact['transectionid'] }} </td>
                                                                <td class="uk-text-left">Discount Adjustment</td>
                                                                <td class="uk-text-right"></td>
                                                                <td class="uk-text-right"></td>
                                                                <td class="uk-text-right">
                                                                    @php
                                                                    $balance=$balance-$contact['amount'];
                                                                    @endphp
                                                                    {{ number_format((float)$contact['amount'], 2, '.', '') }}

                                                                </td>
                                                                <td class="uk-text-right"> {{ number_format((float)$balance, 2, '.', '') }} </td>
                                                            </tr>

                                                        @endif

                                                    @endif

                                                    <?php $count++; ?>

                                                @endforeach

                                            @endif

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
    <script type="text/javascript">
        window.onload = function () {
            $("#payment_made2 td:first-child").text("payment made");
            $("#payment_receive2 td:first-child").text("payment receive");
            $("#sales_commission td:first-child").text("Sales Commission");
        };

        $("#account_filter_dropbox").on('change',function () {

                var acc_id = $(this).val();
                var acc_name = $("select[name='account_filter_dropbox'").find('option:selected').text();

                // Declare variables
                var  filter, table, tr, td, i, debit = 0, credit = 0, balance = 0, heading;

                filter = acc_id;
                table = document.getElementById("account_filter_table");
                tr = table.getElementsByTagName("tr");

                if(filter == 'all')
                {
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            tr[i].style.display = "";

                            //finding debit value & credit value for resetting balance and checking if they non-numeric or not;
                            //if non-numeric set value as 0;
                            //finally calcualte and assign balance
                            debit = parseFloat((tr[i].getElementsByTagName("td")[5]).innerHTML);
                            credit = parseFloat((tr[i].getElementsByTagName("td")[6]).innerHTML);

                            if(isNaN(debit)){
                                debit = 0;
                            }
                            if(isNaN(credit)){
                                credit = 0;
                            }

                            balance += debit - credit;

                            td = tr[i].getElementsByTagName("td")[7];

                            if (td) {
                                td.innerHTML = balance.toFixed(2);
                            }
                       }
                    }

                    //seeting heading text to its original state
                    heading = document.getElementsByClassName("heading_b");
                    heading[0].innerHTML = "{!! $customer['display_name'] !!} Report Details";

                    return false;
                }

                // Loop through all table rows, and hide those who don't match the search query and changing balance column for filtered rows
                for (i = 0; i < tr.length; i++) {

                    td = tr[i].getElementsByTagName("td")[0];

                    if (td) {
                        if (parseInt(td.innerHTML) == parseInt(filter)) {

                            tr[i].style.display = "";

                            //finding debit value & credit value for resetting balance and checking if they non-numeric or not;
                            //if non-numeric set value as 0;
                            //finally calcualte and assign balance
                            debit = parseFloat((tr[i].getElementsByTagName("td")[5]).innerHTML);
                            credit = parseFloat((tr[i].getElementsByTagName("td")[6]).innerHTML);

                            if(isNaN(debit)){
                                debit = 0;
                            }
                            if(isNaN(credit)){
                                credit = 0;
                            }

                            balance += debit - credit;

                            td = tr[i].getElementsByTagName("td")[7];

                            if (td) {
                                td.innerHTML = balance.toFixed(2);
                            }

                        }else {

                            tr[i].style.display = "none";
                        }
                    }
                }

                //adding filtered account name in heading
                heading = document.getElementsByClassName("heading_b");
                heading[0].innerHTML = heading[0].innerHTML.replace(/ *\([^)]*\) */g, "");
                heading[0].innerHTML = heading[0].innerHTML + "( " + acc_name + " Account Only )";

        });

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');
    </script>
@endsection
