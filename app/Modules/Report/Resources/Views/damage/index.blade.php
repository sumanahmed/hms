@extends('layouts.admin')

@section('title', 'Total Damage Report')

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
    <?php $helper = new \App\Lib\Helpers; ?>
    <div class="uk-width-medium-10-10 uk-container-center reset-print">
        <div class="uk-grid uk-grid-collapse">
            <div class="uk-width-large-10-10">

                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview hidden-print">
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                            {!! Form::open(['url' => route('damage_report_filter'), 'method' => 'post', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                                <div class="uk-grid hidden-print" data-uk-grid-margin="">
                                    <div class="uk-width-medium-1-5" >
                                        <div class="md-input-wrapper md-input-filled">
                                            <label for="invoice_date">Company Wise</label>
                                            <select name="company_id" id="company_id" class="md-input" class="company_id">
                                                <option selected disabled value="">Select Company</option>
                                                <option value="0" @if(isset($company_id) && $company_id == 0 ) selected @endif>All</option>
                                                @foreach($companys as $company)
                                                    <option value="{{ $company->id }}" @if(isset($company_id) && $company_id == $company->id) selected @endif>{{ $company->serial." ".$company->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-5">
                                        <div class="md-input-wrapper md-input-filled">
                                            <label for="invoice_date">Damage Type</label>
                                            <select name="damage_type" id="damage_type" class="md-input">
                                                <option selected disabled value="">Damage Type</option>
                                                <option value="1" @if(isset($damage_type) && $damage_type == 1) selected @endif>Total Damage</option>
                                                <option value="2" @if(isset($damage_type) && $damage_type == 2) selected @endif>Total Damage(Break Up)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-5">
                                        <div class="uk-width-medium-2-5">
                                            <label for="invoice_date">Filter From</label>
                                            <input class="md-input" type="text" id="form_date" name="from_date" value="{{ $start }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-5">
                                        <div class="uk-width-medium-2-5">
                                            <label for="invoice_date">Filter To</label>
                                            <input class="md-input" type="text" id="to_date" name="to_date" value="{{ $end }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-5">
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

                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img style="margin-bottom: -20px;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                    <p style="line-height: 5px; margin-top: 35px;"class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                    @if(isset($damage_type) && $damage_type == 1)
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Total Damage Report</p>
                                    @elseif(isset($damage_type) && $damage_type == 2)
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Total Damage Report(Break Up)</p>
                                    @endif
                                    @if(isset($company_name))
                                        <p style="line-height: 8px;" class="heading_b">{{ $company_name }}</p>
                                    @endif
                                    <p style="line-height: 5px;" class="uk-text-small">From {{ $start }} To {{ $end }}</p>
                                </div>
                            </div>

                            <div class="uk-grid uk-margin-large-bottom">

                                @if(isset($damage_type) && $damage_type == 1)
                                    @if(isset($items))
                                        @foreach($items as $key => $item)
                                            <div class="uk-width-medium-1-1">
                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                                        <label class="uk-vertical-align-middle" for="note">Company</label>
                                                    </div>
                                                    <div class="uk-width-medium-2-5">
                                                        <input type="text" class="md-input" value="{{ $helper->getCompanyname($key) }}" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <table class="uk-table">
                                                    <thead>
                                                    <tr class="uk-text-upper">
                                                        <th class="uk-text-left">SL</th>
                                                        <th class="uk-text-left">Product Name</th>
                                                        <th class="uk-text-left">Damaged</th>
                                                        <th class="uk-text-left">Adjusted</th>
                                                        <th class="uk-text-left">Damage Stock</th>
                                                        <th class="uk-text-left">Purchase Price</th>
                                                        <th class="uk-text-left">Value</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i=1; $total_value = 0; $adjusted = 0; $damaged = 0;?>
                                                    @foreach($item as $value)
                                                        @php
                                                            $damage     = $value['damaged'] != null ? $value['damaged'] : 0;
                                                            $adjust     = $value['adjusted'] != null ? $value['adjusted'] : 0;
                                                            $stock      = $damage - $adjust;
                                                        @endphp
                                                        <tr class="uk-table-middle">
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $value['item_name'] }}</td>
                                                            <td>{{  $value['damaged'] }}</td>
                                                            <td>{{ $adjust }}</td>
                                                            <td>{{ $stock  }}</td>
                                                            <td>{{ $value['purchase_price'] }}</td>
                                                            <td>{{ $stock * $value['purchase_price'] }}</td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                        @php
                                                            $total_value += $stock * $value['purchase_price'];
                                                            $adjusted   += $adjust;
                                                            $damaged    += $damage;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                    <tr class="uk-table-middle">
                                                        <td></td>
                                                        <td><strong>Total</strong></td>
                                                        <td><strong>{{ $damaged }}</strong></td>
                                                        <td><strong>{{ $adjusted }}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong>{{ $total_value }}</strong></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif

                                @if(isset($damage_type) && $damage_type == 2)
                                    @if(isset($alls))
                                        @foreach($alls as $key => $all)
                                            <div class="uk-width-medium-1-1">
                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                                        <label class="uk-vertical-align-middle" for="note">Company</label>
                                                    </div>
                                                    <div class="uk-width-medium-2-5">
                                                        <input type="text" class="md-input" value="{{ $helper->getCompanyname($key) }}" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                @if(isset($items))
                                                    @foreach($items as $index => $item)
                                                        <p style="margin: 25px 0;">Date : {{ $helper->getDate($index) }}</p>
                                                        <table class="uk-table">
                                                            <thead>
                                                            <tr class="uk-text-upper">
                                                                <th class="uk-text-left">SL</th>
                                                                <th class="uk-text-left">Product Name</th>
                                                                <th class="uk-text-left">Damage Taken</th>
                                                                <th class="uk-text-left">Damage Given</th>
                                                                <th class="uk-text-left">Remaining</th>
                                                                <th class="uk-text-left">Purchase Price</th>
                                                                <th class="uk-text-left">Value</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $i=1; $total_value = 0; $total_damage_taken = 0; $total_damage_given = 0;?>
                                                            @foreach($item as $value)
                                                                @php
                                                                    $damage_taken   = isset($value['damage_taken']) ? $value['damage_taken'] : 0;
                                                                    $damage_given   = isset($value['damage_given']) ? $value['damage_given'] : 0;
                                                                    $stock          = $damage_taken - $damage_given;
                                                                @endphp
                                                                <tr class="uk-table-middle">
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $value['item_name'] }}</td>
                                                                    <td>{{ $damage_taken }}</td>
                                                                    <td>{{ $damage_given }}</td>
                                                                    <td>{{ $stock  }}</td>
                                                                    <td>{{ $value['item_purchase_rate'] }}</td>
                                                                    <td>{{ $stock * $value['item_purchase_rate'] }}</td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                                @php
                                                                    $total_value            += $stock * $value['item_purchase_rate'];
                                                                    $total_damage_taken     += $damage_taken;
                                                                    $total_damage_given     += $damage_given;
                                                                @endphp
                                                            @endforeach
                                                            </tbody>
                                                            <tr class="uk-table-middle">
                                                                <td></td>
                                                                <td><strong>Total</strong></td>
                                                                <td><strong>{{ $total_damage_taken }}</strong></td>
                                                                <td><strong>{{ $total_damage_given }}</strong></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><strong>{{ $total_value }}</strong></td>
                                                            </tr>
                                                        </table>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                @endif

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

    <script>
        //Get Company or Product by change of Report Type
        $('#report_type').change(function() {
            var report_type = $("#report_type option:selected").val();
            if(report_type == 1){
                $("#companySection").show();
                $("#productSection").hide();
            }
            else if(report_type == 2){
                $("#productSection").show();
                $("#companySection").hide();
            }
            else{
                $("#companySection").hide();
                $("#productSection").hide();
            }

        });

        //Get Invoice by change of Record Type
        $('#record_type').change(function() {
            var record_type = $("#record_type option:selected").val();
            if(record_type == 1){
                $("#invoiceSection").show();
            }
            else{
                $("#invoiceSection").hide();
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

    </script>
@endsection
