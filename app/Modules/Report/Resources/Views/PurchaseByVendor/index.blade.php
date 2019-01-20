@extends('layouts.admin')

@section('title', 'Purchase By Vendor Report '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection
@section('content_header')

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
        }
    </style>
@endsection
@section('content')
    @if($errors->first('from_date') || $errors->first('to_date'))
        <div class="uk-alert uk-alert-warning" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            Date Range is Required
        </div>
    @endif

    <div class="uk-width-medium-10-10 uk-container-center reset-print">
        <div class="uk-grid uk-grid-collapse" data-uk-grid-margin>
            <div class="uk-width-large-10-10">
                <div class="md-card md-card-single main-print">
                    <div id="invoice_preview">
                        <div class="md-card-toolbar">
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
                                        {!! Form::open(['method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
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
                                                    <label for="uk_dp_1">Form</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="from_date"
                                                           data-uk-datepicker="{format:'YYYY-MM-DD'}" required>
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i
                                                                class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">To</label>
                                                    <input class="md-input" type="text" id="uk_dp_1" name="to_date"
                                                           data-uk-datepicker="{format:'YYYY-MM-DD'}" required>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close
                                            </button>
                                            <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">
                                                Search
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
                                    <p style="line-height: 5px;" class="heading_b uk-text-success">Purchase by Vendor Report</p>
                                    <p style="line-height: 5px;" class="uk-text-small">From {{$start}} To {{$end}}</p>

                                </div>
                            </div>
                            <div class="uk-grid uk-margin-large-bottom">
                                <div class="uk-width-1-1">
                                    <table class="uk-table">
                                        <thead>
                                        <tr class="uk-text-upper">
                                            <th>Name</th>
                                            <th>Total Purchase</th>
                                            <th>Total Payment</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($bill as $b)
                                            <tr>
                                                <td> <a href="{{ route('show_details_purchase_by_vendor_report' ,[$b['vendor_id'], $start, $end ]) }}">{{$b['name']}}</a></td>
                                                <td>{{$b['total_purchase']}}</td>
                                                <td>{{$b['total_payment']}}</td>
                                                <td>{{$b['total_purchase']}}</td>
                                            </tr>

                                            @endforeach



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
        $('#sidebar_reports').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');

    </script>

    <!-- handlebars.js -->
    <script src="{{ url('admin/bower_components/handlebars/handlebars.min.js')}}"></script>
    <script src="{{ url('admin/assets/js/custom/handlebars_helpers.min.js')}}"></script>

    <!--  invoices functions -->
    <script src="{{ url('admin/assets/js/pages/page_invoices.min.js')}}"></script>

@endsection
