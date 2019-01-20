<style>
    .update-picker-year option,.update-picker-month option{
        color:black !important;
        background: white; !important;

    }

    table.uk-table {
        margin-top: -20px;
        margin-left: 30px;
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
</style>
<div class="uk-width-medium-10-10 uk-container-center reset-print">
    <div class="uk-grid uk-grid-collapse" data-uk-grid-margin>
        <div class="uk-width-large-10-10">
            <div class="uk-grid">

                <div class="uk-width-small-5-5 uk-text-center" style="margin-bottom: 40px; text-align: center">
                    <img class="logo_regular" src="uploads/op-logo/logo.png" alt="" height="15" width="71"/>
                    <p style="line-height: 5px; margin-top: 35px;" class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                    <p style="line-height: 5px;" class="heading_b">{{ $customer['display_name'] }} Report Details</p>
                    <p style="line-height: 5px;">{{ $current_branch['branch_name'] }}</p>
                    <p style="line-height: 10px;"> {{ $start." ". " to " ." $end" }} </p>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <table class="uk-table">
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
            <div class="uk-grid" style="margin-left: 40px;margin-top:20px;">
                <div class="uk-width-1-1">
                    <span class="uk-text-muted uk-text-small uk-text-italic">Notes:</span>
                </div>
            </div>
        </div>
    </div>
</div>

