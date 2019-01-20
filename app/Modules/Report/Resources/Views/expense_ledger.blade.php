@extends('layouts.admin')

@section('title', 'Expense Ledger '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('styles')
    <style>
        #expense_filter_table thead .sorting:after,
        #expense_filter_table thead .sorting_asc:after,
        #expense_filter_table thead .sorting_desc:after {
            content: '';
        }
        
        #list_table_right tr td:nth-child(1){

            white-space:nowrap;
        }
        #list_table_right{
           width: 100%;
           padding: 30px;

        }
        #list_table_right tr td{
              text-align: center;
          }
        #list_table_right tr th{
           border-bottom: 1px solid black;
           border-top: 1px solid black;
           font-size: 10px;
        }
        #list_table_right tr td:last-child{

            white-space:nowrap;
        }
        @media print {
            #list_table_right tr td{
             border: none;

            }
            #list_table_right_parent tr th{
                border:1px solid black ;
            }
            #list_table_right_parent, #list_table_right{

             font-size: 11px !important;
             border-spacing: 0px;
             border-collapse: collapse;


            }
            #list_table_right{
                margin-left: 10px;
            }
            body{
                margin-top: -40px;
            }
            #total, #table_close,#table_open,#list_table_right{
                font-size: 11px !important;
            }
            .md-card-toolbar{
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
                    <div class="md-card-toolbar hidden-print">
                        <div class="md-card-toolbar-actions hidden-print" style="width: 100%">
                            <div data-uk-button-radio="{target:'.md-btn'}" style="float: right; ">
                                <select data-md-selectize=""  data-md-selectize-bottom="" data-uk-tooltip="{pos:'top'}" id="expense_dropbox" title="Select with Expense Account">
                                    <option style="text-align: left;" value=""> Select Expense Account... </option>
                                    <option value = "all">All</option>
                                    
                                    @for($k = 0; $k < count($expense); ++$k)
                                    
                                        @php
                                            $id = [];
                                            
                                            if(isset($expense[$k]['jid']))
                                                $id = explode(',', $expense[$k]['jid']);
                                        @endphp

                                        <option value = "{{ $id[0] }}"> {{ $expense[$k]['expenseAccountID'] }} </option>
                                        
                                    @endfor
                                    
                                </select>
                            </div>
                            <div style="float: right">
                                <input class="md-input" id="search_expense_account" placeholder="Search Expense Account " style="position: relative; top:-10px; width: 300px;" type="text">
                                </input>
                            </div>
                            <i class="md-icon material-icons" id="invoice_print">ювн</i>
                            <!--end  -->
                            <div aria-expanded="true" aria-haspopup="true" class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                <a data-uk-modal="{target:'#coustom_setting_modal'}" href="#">
                                    <i class="material-icons">
                                        &#xE8B8;
                                    </i>
                                    <span>
                                        Custom Setting
                                    </span>
                                </a>
                            </div>

                            <!--coustorm setting modal start -->
                            <div class="uk-modal" id="coustom_setting_modal">
                                <div class="uk-modal-dialog">
                                {!! Form::open(['url' => 'report/expense/ledger', 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Select Date Range<i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>

                                    <div class="uk-width-large-2-2 uk-width-2-2">
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-input-group">
                                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                <label for="uk_dp_1">From</label>
                                                <input class="md-input" type="text" id="uk_dp_1" name="from_date" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                            </div>
                                        </div>
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-input-group">
                                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                <label for="uk_dp_1">To</label>
                                                <input class="md-input" type="text" id="uk_dp_1" name="to_date" data-uk-datepicker="{format:'DD.MM.YYYY'}">
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
                        
                        <div class="uk-grid" data-uk-grid-margin="">
                            
                            <div class="uk-width-small-5-5 uk-text-center">
                                <img class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>
                                <p style="line-height: 5px;" class="uk-text-large">{{ $OrganizationProfile->display_name }}</p>
                                <p style="line-height: 5px;" class="heading_b">Expense Ledger</p>
                                <p style="line-height: 5px;" class="uk-text-small">From {{$start}}  To {{$end}}</p>
                            </div>
                        </div>
                        <div id="list_table_right_parent" class="uk-grid" style="font-size:12px;">
                            <div class="uk-width-1-1">
                                <table id="list_table_right">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th style="text-align: left">Expense Account</th>
                                        <th style="text-align: left">Date</th>
                                        <th style="text-align: right">Amount</th>
                                        <th>Paid To</th>
                                        <th>Reference</th>
                                        <th>Note</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                      @php
                                        $grandTotal=0;
                                      @endphp
                                      
                                      @for($j = 0; $j < count($result); ++$j)

                                        @php
                                            $jid = [];
                                            $jdate = [];
                                            $jamount = [];
                                            $evendor = [];
                                            $eref = [];
                                            $enote = [];
    
                                            if(!isset($result[$j]['sum']))
                                                $result[$j]['sum'] = 0;
                                            if(isset($result[$j]['jid']))
                                                $jid = explode(',',$result[$j]['jid']);
                                            if(isset($result[$j]['jdate']))
                                                $jdate = explode(',',$result[$j]['jdate']);
                                            if(isset($result[$j]['jamount']))
                                                $jamount = explode(',',$result[$j]['jamount']);
                                            if(isset($result[$j]['evendor']))
                                                $evendor = explode(',',$result[$j]['evendor']);
                                            if(isset($result[$j]['eref']))
                                                $eref = explode(',',$result[$j]['eref']);
                                            if(isset($result[$j]['enote']))
                                                $enote = explode(',',$result[$j]['enote']);
                                        @endphp
                                        
                                        
                                        <tr class="uk-table-middle">
                                           <td style="display: none;">{{ isset($result[$j]['id']) ? $result[$j]['id'] : $jid[0] }}</td>
                                           <td id="exepenceAccountId" style="text-align: left">{{ isset($result[$j]['expenseAccountID'])? $result[$j]['expenseAccountID'] : '' }}</td>
                                           <td style="text-align: left">Opening Balance</td>
                                           <td style="text-align: right">{{ isset($result[$j]['sum']) ? $result[$j]['sum'] : 0 }}</td>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                        </tr>

                                          @php
                                              $subTotal=0;
                                              $subTotal=$subTotal + isset($result[$j]['sum']) ? $result[$j]['sum'] : 0;
                                              $grandTotal = $grandTotal + isset($result[$j]['sum']) ? $result[$j]['sum'] : 0;
                                          @endphp

                                          @for($i = 0; $i < count($jdate); $i++)
                                            <tr class="uk-table-middle">
                                               <td style="display: none;">{{ isset($result[$j]['id'])? $result[$j]['id'] : $jid[0] }}</td>
                                               <td></td>
                                               <td style="text-align: left">{{date('d-m-Y', strtotime($jdate[$i]))}}</td>
                                               <td style="text-align: right">{{$jamount[$i]}}</td>
                                               <td>{{$evendor[$i]}}</td>
                                               <td>{{$eref[$i]}}</td>
                                               <td>{{$enote[$i]}}</td>
                                            </tr>
                                            
                                            @php
                                                $subTotal=$subTotal+$jamount[$i];
                                                $grandTotal=$grandTotal+$jamount[$i];
                                            @endphp
                                            
                                          @endfor

                                          <tr class="uk-table-middle">
                                             <td style="display: none;">{{ isset($result[$j]['id'])? $result[$j]['id'] : $jid[0] }}</td>
                                             <td></td>
                                             <td style="text-align: left"><strong>Sub Total</strong></td>
                                             <td style="text-align: right" id ="expaccnt{{ isset($result[$j]['id'])? $result[$j]['id'] : $jid[0] }}"><strong>{{ $subTotal }}</strong></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                          </tr>

                                      @endfor

                                      <tr class="uk-table-middle" id="grandTotal">
                                        <td></td>
                                        <td style="text-align: left"><strong>GRAND TOTAL</strong></td>
                                        <td style="text-align: right" id=""><strong>{{$grandTotal}}</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      </tr>

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

    <script src="{{ url('admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- handlebars.js -->
    <script src="{{ url('admin/bower_components/handlebars/handlebars.min.js')}}"></script>
    <script src="{{ url('admin/assets/js/custom/handlebars_helpers.min.js')}}"></script>

    <!--  invoices functions -->
    <script src="{{ url('admin/assets/js/pages/page_invoices.min.js')}}"></script>

    <script type="text/javascript">
        //Dropdown Expense Account Search
        $("#expense_dropbox").on('change',function () {

            var expense_id = $(this).find(":selected").val();

            // Declare variables
            var  filter, table, tr, td, i, grand_total, expaccntID;

            filter = expense_id;
            table = document.getElementById("list_table_right");
            grand_total = document.getElementById("grandTotal");
            expaccntID = document.getElementById("expaccnt" + filter);
            tr = table.getElementsByTagName("tr");

            if (filter == 'all') {
                for (i = 0; i < tr.length; i++) {

                    td = tr[i].getElementsByTagName("td")[0];

                    if (td) {

                        tr[i].style.display = "";
                        grand_total.getElementsByTagName("td")[2].innerHTML = "<strong>" + {!! $grandTotal !!} + "</strong>";
                    }
                }
                return false;
            }

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[0];

                if (td) {

                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        grand_total.getElementsByTagName("td")[2].innerHTML = expaccntID.innerHTML;
                    } else {
                        tr[i].style.display = "none";
                        grand_total.style.display = "";
                    }
                }
            }

        });

        //Search Expense Account
        $("#search_expense_account").on("input",function () {
            var expense_id = $(this).val().toUpperCase();
            // Declare variables
            var  filter, table, tr, td, i;

            filter = expense_id
            table = document.getElementById("list_table_right");
            tr = table.getElementsByTagName("tr");
            if(filter=='all'){
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {

                        tr[i].style.display = "";

                    }
                }
                return false;
            }
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[1];

                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        })


        $("#invoice_print").click(function(){
           $("#list_table_right").removeClass('uk_table');
        });

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');

    </script>
@endsection
