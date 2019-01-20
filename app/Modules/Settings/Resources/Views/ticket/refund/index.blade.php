@extends('layouts.main')

@section('title', 'Ticket Refund')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')

    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>

                <div class="uk-width-xLarge-10-10  uk-width-large-10-10">
                    <div class="md-card">
                        <div class="md-card-toolbar" style="">
                            <div class="md-card-toolbar-actions hidden-print">
                                <!--end  -->
                                <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}" aria-haspopup="true" aria-expanded="true"> <a href="#" data-uk-modal="{target:'#coustom_setting_modal'}"><i class="material-icons">&#xE8B8;</i><span>Custom Setting</span></a>

                                </div>
                                <!--coustorm setting modal start -->
                                <div class="uk-modal" id="coustom_setting_modal">
                                    <div class="uk-modal-dialog">
                                        {!! Form::open(['url' => 'ticket/refund', 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">Select Date Range {{ session('branch_id')==1?"and Branch":'' }}   <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                        </div>

                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            @if(session('branch_id')==1)
                                                <div class="uk-width-medium-2-2">
                                                    <div class="uk-input-group">
                                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-building"></i></span>

                                                        <select style="width: 90%" class="styled-select slate"  id="report_account_id" name="branch_id" >

                                                            @if(isset($branch_id))
                                                                @foreach($branchs as $branch)
                                                                    <option {{ ($branch_id==$branch->id)?"selected":'' }} value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach($branchs as $branch)
                                                                    <option  value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                                @endforeach

                                                            @endif
                                                        </select>

                                                    </div>
                                                    <br/>
                                                </div>
                                            @endif
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">From</label>
                                                    <input value="{{ isset($from_date)?$from_date:date('Y-m-d') }}" required class="md-input" type="text" id="uk_dp_1" name="from_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                    <label for="uk_dp_1">To</label>
                                                    <input value="{{ isset($to_date)?$to_date:date('Y-m-d') }}" required class="md-input" type="text" id="uk_dp_1" name="to_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
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
                        
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Ticket Refund List</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            <div class="uk-overflow-container uk-margin-bottom">
                                <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                <table class="uk-table" cellspacing="0" width="100%" id="data_table" >
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Submit Date</th>
                                        <th>IATA Submit Date</th>
                                        <th>Customer Name</th>
                                        <th>Ticket Number</th>
                                        <th>Passenger Name</th>
                                        <th>Sector</th>
                                        <th class="uk-text-center">Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Submit Date</th>
                                        <th>IATA Submit Date</th>
                                        <th>Customer Name</th>
                                        <th>Ticket Number</th>
                                        <th>Passenger Name</th>
                                        <th>Sector</th>
                                        <th class="uk-text-center">Action</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>
                                    <?php $count = 1; ?>
                                    @foreach($refund as $value)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ date('d-m-Y',strtotime($value->submit_date)) }}</td>
                                            <td>{{ date('d-m-Y',strtotime($value->iata_submit_date)) }}</td>
                                            <td>{{ $value->customerId['display_name'] }}</td>
                                            <td>{{ $value->ticket_number }}</td>
                                            <td>{{ $value->first_name.' '.$value->last_name }}</td>
                                            <td>{{ $value->sectorId['item_name'] }} @if($value->reference && $value->reference != " ") {{ " - " . $value->reference }} @endif</td>

                                            <td class="uk-text-center" style="white-space:nowrap !important;">

                                                <a href="{{ $value->bill_id?route('ticket_refund_bill_show',['id' => $value->bill_id?$value->bill_id:0,'order'=>$value->id]):'javascript::void(0);' }}"><i data-uk-tooltip="{pos:'top'}" title="bill" class="material-icons" style="font-size: 30px;color: {{$value->bill_id?'#109300': ''}}; font-weight: bold;">B</i></a>

                                                <a href="{{ $value->invoice_id?route('ticket_refund_invoice_show',['id' => $value->invoice_id?$value->invoice_id:0,'order'=>$value->id]):'javascript::void(0);' }}"><i data-uk-tooltip="{pos:'top'}" title="invoice" class="material-icons" style="font-size: 30px;color: {{$value->invoice_id?'#109300': ''}}; font-weight: bold;">I</i></a>
                                                
                                                <a href="{{ route('ticket_refund_show', ['id' => $value->id]) }}"><i data-uk-tooltip="{pos:'top'}" title="View" class="material-icons">visibility</i></a>
                                                <a href="{{ route('ticket_refund_edit',$value->id) }}"><i data-uk-tooltip="{pos:'top'}" title="Edit Commission" class="md-icon material-icons">&#xE254;</i></a>
                                                <a class="delete_btn"><i data-uk-tooltip="{pos:'top'}" title="Delete" class="md-icon material-icons" style="font-size: 30px;font-size: 20px; font-weight: bold;">&#xE872;</i></a>
                                                <input type="hidden" class="commission_id" value="{{ $value->id }}">
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Add branch plus sign -->

                            <div class="md-fab-wrapper branch-create">
                                <a id="add_branch_button" href="{{ route('ticket_refund_create') }}" class="md-fab md-fab-accent branch-create">
                                    <i class="material-icons">&#xE145;</i>
                                </a>
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
        $('#sidebar_ticket_all_refund').addClass('act_item');
        $('#sidebar_ticketing').addClass('current_section');
        $(window).load(function(){
            $("#tiktok").trigger('click');
        })

        $('.delete_btn').click(function () {
            var id = $(this).next('.commission_id').val();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                if(id){
                    window.location.href = "{{ route('ticket_refund_destroy',['id'=>'']) }}"+"/"+id;
                }else {
                    window.location.href = "{{ route('ticket_refund_destroy',['id'=>'']) }}"+"/"+"%00";
                }

            })
        })
    </script>
    
@endsection