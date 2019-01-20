@extends('layouts.admin')

@section('title', 'Sales Summary')

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
                            {!! Form::open(['url' => route('sales_summary_filter'), 'method' => 'post', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                                <div class="uk-grid hidden-print" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-5 uk-row-first">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="invoice_number">Select Invoice</label>
                                        <select name="invoice_number" id="invoice_number" class="md-input">
                                            <option selected disabled value="">Select</option>

                                        </select>
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
                                    <img style="margin-bottom: -20px;" class="logo_regular"
                                         src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                    <p style="line-height: 5px; margin-top: 35px;"class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>

                                    <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Sales Summary</p>
                                    @if(isset($invoice_number))
                                         <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Invoice : {{ "FSINV-".$invoice_number }}</p>
                                    @endif
                                    @if(isset($final_sales[0]->road_id))
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Area : {{ $final_sales[0]->road->name }}</p>
                                    @endif
                                    @if(isset($final_sales[0]->employee_id))
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">DSR : {{ $final_sales[0]->employee->display_name }}</p>
                                    @endif
                                    @if(isset($final_sales[0]->company_id))
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Company : {{ $final_sales[0]->company->display_name }}</p>
                                    @endif
                                    @if(isset($final_sales[0]->date))
                                        <p style="line-height: 5px; margin-top: 18px;"class="uk-text-large">Date : {{ $final_sales[0]->date }}</p>
                                    @endif

                                </div>
                            </div>
                            <div class="uk-grid uk-margin-large-bottom">
                                @if(isset($final_sales))
                                    <div class="uk-width-1-1">
                                        <table class="uk-table">
                                            <thead>
                                            <tr class="uk-text-upper">
                                                <th class="uk-text-left">SL</th>
                                                <th class="uk-text-left">Product Name</th>
                                                <th class="uk-text-left">Quantity</th>
                                                <th class="uk-text-left">Value</th>
                                                <th class="uk-text-left">Return Quantity</th>
                                                <th class="uk-text-left">Free Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=1; $total_value = 0; $total_quantity = 0; $total_return_quantity = 0; $total_free_quantity = 0;?>
                                            @foreach($final_sales as $final_sale)
                                                <tr class="uk-table-middle">
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $final_sale->item_name }}</td>
                                                    <td>{{ $final_sale->quantity }}</td>
                                                    <td>{{ $final_sale->quantity * $final_sale->company_rate }}</td>
                                                    <td>{{ $final_sale->return_quantity }}</td>
                                                    <td>{{ $final_sale->free_quantity }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                                @php
                                                    $total_quantity             += $final_sale->quantity;
                                                    $total_value                += $final_sale->quantity * $final_sale->company_rate;
                                                    $total_return_quantity      += $final_sale->return_quantity;
                                                    $total_free_quantity        += $final_sale->free_quantity;
                                                @endphp
                                            @endforeach
                                            </tbody>
                                            <tr class="uk-table-middle">
                                                <td></td>
                                                <td><strong>Total</strong></td>
                                                <td><strong>{{ $total_quantity }}</strong></td>
                                                <td><strong>{{ $total_value }}</strong></td>
                                                <td><strong>{{ $total_return_quantity }}</strong></td>
                                                <td><strong>{{ $total_free_quantity }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>

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
        //Get product by select company
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
