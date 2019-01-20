@extends('layouts.admin')

@section('title', 'Special Offer')

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

@section('content')
    <div class="uk-width-medium-10-10 uk-container-center reset-print">
        <div class="uk-grid uk-grid-collapse">
            <div class="uk-width-large-10-10">

                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview hidden-print">
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                            {!! Form::open(['url' => route('report_special_offer_filter'), 'method' => 'post', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                                <div class="uk-grid hidden-print" data-uk-grid-margin="">
                                    <div class="uk-width-medium-1-3 uk-row-first">
                                        <div class="md-input-wrapper md-input-filled">
                                            <select name="company_id" id="company_id" class="md-input" class="company_id">
                                                <option selected disabled value="">Select Company</option>
                                                @foreach($companys as $company)
                                                    <option value="{{ $company->id }}" @if(isset($company_id) && $company_id == $company->id) selected @endif>{{ $company->serial." ".$company->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="uk-width-medium-2-5">
                                            <label for="invoice_date">Filter From</label>
                                            <input class="md-input" type="text" id="form_date" name="from_date" value="{{ $start }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="uk-width-medium-2-5">
                                            <label for="invoice_date">Filter To</label>
                                            <input class="md-input" type="text" id="to_date" name="to_date" value="{{ $end }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid hidden-print" data-uk-grid-margin="">
                                    <div class="uk-width-medium-1-4 uk-row-first">
                                        <p>
                                            <input type="radio" name="offer_type" id="offer_detail" data-md-icheck value="1" @if(isset($offer_type) && $offer_type == 1) checked @endif />
                                            <label for="offer_detail" class="inline-label">Offer Detail</label>
                                        </p>
                                    </div>
                                    <div class="uk-width-medium-1-4">
                                        <p>
                                            <input type="radio" name="offer_type" id="claim_detail" data-md-icheck value="2" @if(isset($offer_type) && $offer_type == 2) checked @endif />
                                            <label for="claim_detail" class="inline-label">Claim Detail</label>
                                        </p>
                                    </div>
                                    <div class="uk-width-medium-1-4">
                                        <p>
                                            <input type="radio" name="offer_type" id="free_receive" data-md-icheck value="3" @if(isset($offer_type) && $offer_type == 3) checked @endif />
                                            <label for="free_receive" class="inline-label">Free Receive</label>
                                        </p>
                                    </div>

                                    <div class="uk-width-medium-1-4">
                                        <button type="submit" class="md-btn md-btn-primary">Filter</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview hidden-print">
                        <div class="md-card-toolbar hidden-print">
                            <div class="md-card-toolbar-actions hidden-print">
                                <i class="md-icon material-icons" id="invoice_print"></i>
                            </div>
                            <h3 class="md-card-toolbar-heading-text large" id="invoice_name"></h3>
                        </div>
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">

                            @if(isset($offer_type) && $offer_type == 1)
                                <div class="uk-grid" data-uk-grid-margin="">
                                    <div class="uk-width-small-5-5 uk-text-center">
                                        <img style="margin-bottom: -20px;" class="logo_regular"
                                             src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                        <p style="line-height: 5px; margin-top: 35px;"class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Offer Detail</p>
                                        @if(isset($company_name))
                                            <p style="line-height: 8px;" class="heading_b">{{ $company_name }}</p>
                                        @endif
                                        <p style="line-height: 5px;" class="uk-text-small">From {{ $start }} To {{ $end }}</p>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-bottom">
                                    <div class="uk-width-1-1">
                                        <table class="uk-table">
                                            <thead>
                                            <tr class="uk-text-upper">
                                                <th class="uk-text-left">SL</th>
                                                <th class="uk-text-left">Offer Validity</th>
                                                <th class="uk-text-left">SKU</th>
                                                <th class="uk-text-left">Qty</th>
                                                <th class="uk-text-left">Free SKU</th>
                                                <th class="uk-text-left">Qty</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @if(isset($special_offers))
                                                    @foreach($special_offers as $special_offer)
                                                        <tr class="uk-table-middle">
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $special_offer->from_date." to ".$special_offer->to_date }}</td>
                                                            <td>{{ $special_offer->item->product_code." ".$special_offer->item->item_name }}</td>
                                                            <td>{{ $special_offer->sku_qty }}</td>
                                                            <td>{{ $special_offer->freeItem->product_code." ".$special_offer->freeItem->item_name }}</td>
                                                            <td>{{ $special_offer->free_sku_qty }}</td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            @elseif(isset($offer_type) && $offer_type == 2)
                                <div class="uk-grid" data-uk-grid-margin="">
                                    <div class="uk-width-small-5-5 uk-text-center">
                                        <img style="margin-bottom: -20px;" class="logo_regular"
                                             src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                        <p style="line-height: 5px; margin-top: 35px;"class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Claim Detail</p>
                                        @if(isset($company_name))
                                            <p style="line-height: 8px;" class="heading_b">{{ $company_name }}</p>
                                        @endif
                                        <p style="line-height: 5px;" class="uk-text-small">Special Offer From {{ $start }}Special Offer To {{ $end }}</p>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-bottom">
                                    <div class="uk-width-1-1">
                                        <table class="uk-table">
                                            <thead>
                                                <tr class="uk-text-upper">
                                                    <th class="uk-text-left">SL</th>
                                                    <th class="uk-text-left">SKU</th>
                                                    <th class="uk-text-left">Purchase</th>
                                                    <th class="uk-text-left">Free SKU</th>
                                                    <th class="uk-text-left">Qty</th>
                                                    <th class="uk-text-left">Claimable</th>
                                                    <th class="uk-text-left">Received Free</th>
                                                    <th class="uk-text-left">Total Received</th>
                                                    <th class="uk-text-left">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1; ?>
                                            @if(isset($claims))
                                                @foreach($claims as $claim)
                                                    <tr class="uk-table-middle">
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $claim->item->product_code." ".$claim->item->item_name }}</td>
                                                        <td>{{ $claim->quantity }}</td>
                                                        <td>{{ $claim->freeItem->product_code." ".$claim->freeItem->item_name }}</td>
                                                        <td>{{ $claim->free_sku_qty }}</td>
                                                        <td>{{ $claim->free_sku_qty * $claim->freeItem->item_purchase_rate}}</td>
                                                        <td>{{ $claim->received_quantity }}</td>
                                                        <td>{{ $claim->received_quantity * $claim->free_sku_qty }}</td>
                                                        <td>{{ ($claim->free_sku_qty * $claim->freeItem->item_purchase_rate) - ($claim->received_quantity * $claim->free_sku_qty) }}</td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            @else

                                <div class="uk-grid" data-uk-grid-margin="">
                                    <div class="uk-width-small-5-5 uk-text-center">
                                        <img style="margin-bottom: -20px;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                        <p style="line-height: 5px; margin-top: 35px;"class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Free Received</p>
                                        @if(isset($company_name))
                                            <p style="line-height: 8px;" class="heading_b">{{ $company_name }}</p>
                                        @endif
                                        <p style="line-height: 5px;" class="uk-text-small">Special Offer From {{ $start }}Special Offer To {{ $end }}</p>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-bottom">
                                    <div class="uk-width-1-1">
                                        <table class="uk-table">
                                            <thead>
                                                <tr class="uk-text-upper">
                                                    <th class="uk-text-left">SL</th>
                                                    <th class="uk-text-left">Date</th>
                                                    <th class="uk-text-left">Offer Name</th>
                                                    <th class="uk-text-left">Product</th>
                                                    <th class="uk-text-left">Rate</th>
                                                    <th class="uk-text-left">Received Qty</th>
                                                    <th class="uk-text-left">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1; ?>
                                            @if(isset($free_receives))
                                                @foreach($free_receives as $free_receive)
                                                    <tr class="uk-table-middle">
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $free_receive->date }}</td>
                                                        <td>None</td>
                                                        <td>{{ $free_receive->freeItem->product_code." ".$free_receive->freeItem->item_name }}</td>
                                                        <td>{{ $free_receive->freeItem->item_purchase_rate}}</td>
                                                        <td>{{ $free_receive->received_quantity }}</td>
                                                        <td>{{ $free_receive->received_quantity * $free_receive->free_sku_qty }}</td>
                                                        <@php
                                                            $total_value = 0;
                                                            $total_value +=  ($free_receive->received_quantity * $free_receive->free_sku_qty);
                                                        @endphp
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ $total_value }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            @endif

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

    <script>
        //Get product by select company
        $('#company_id').change(function() {
            var company_id = $("#company_id option:selected").val();
            if(company_id){
                $.get('/report/outlet-record/ajax-road/'+ company_id, function(data){
                    $('#road_id').empty();
                    $('#road_id').append('<option selected disabled >Select Road</option>');
                    $('#road_id').append('<option value="0">All</option>');
                    for(var i =0; i< data.length; i++){
                        $('#road_id').append( ' <option value="'+data[i].id+'">'+data[i].name+'</option> ' );
                    }
                });
            }
        });
    </script>

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
        $(document).ready(function() {
            $("#company_id").select2();
        });
    </script>
@endsection
