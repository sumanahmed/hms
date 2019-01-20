@extends('layouts.admin')

@section('title', 'Outlet Record')

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
                            {!! Form::open(['url' => route('outlet_record_filter'), 'method' => 'post', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                            <div class="uk-grid hidden-print" data-uk-grid-margin="">

                                <div class="uk-width-medium-1-3 uk-row-first">
                                    <div class="md-input-wrapper md-input-filled">
                                        <select name="company_id" id="company_id" class="md-input">
                                            <option selected disabled value="">Select Company</option>
                                            <option value="0">All</option>
                                            @foreach($companys as $company)
                                                <option value="{{ $company->id }}" @if(isset($company) && $company->company_id == $company->id) selected @endif>{{ $company->serial." ".$company->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <select class="md-input" name="road_id" id="road_id">
                                            <option selected disabled value="">Select Road</option>
                                            <option value="0">All</option>
                                            @foreach($roads as $road)
                                                <option value="{{ $road->id }}" @if(isset($road_id) && $road_id == $road->id) selected @endif>{{ $road->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-3">
                                    <button type="submit" class="md-btn md-btn-primary">Submit</button>
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
                        </div>
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">

                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img style="margin-bottom: -20px;" class="logo_regular"
                                         src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                    <p style="line-height: 5px; margin-top: 35px;"
                                       class="uk-text-large">{{ $OrganizationProfile->company_name }}</p>
                                    <p style="line-height: 5px;" class="heading_b">Outlet Record</p>
                                </div>
                            </div>

                            @if(isset($outlets))
                                @foreach($outlets as $outlet)
                                <div class="uk-grid" data-uk-grid-margin="" style="margin-top:20px;margin-bottom:40px;">
                                    <div class="uk-width-medium-1-2 uk-row-first">
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5  uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="note">Company</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <input type="text" class="md-input" value="{{ $company->display_name }}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5  uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="note">Road</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <input type="text" class="md-input" value="{{ $outlet->road_name }}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-bottom">
                                    <div class="uk-width-1-1">
                                        <table class="uk-table">
                                            <thead>
                                            <tr class="uk-text-upper">
                                                <th class="uk-text-left">SL</th>
                                                <th class="uk-text-left">Outlet Name</th>
                                                <th class="uk-text-left">Proprietor Name</th>
                                                <th class="uk-text-left">Address</th>
                                                <th class="uk-text-left">Mobile Number</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach($outlets as $key => $new_road)
                                                    <tr class="uk-table-middle">
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $new_road->display_name }}</td>
                                                        <td>{{ $new_road->propietor }}</td>
                                                        <td>{{ $new_road->address }}</td>
                                                        <td>{{ $new_road->mobile }}</td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
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

    </script>
@endsection
