@extends('layouts.admin')

@section('title', 'Contact Report '.date("Y-m-d h-i-sa"))

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('styles')
    <style>
        #contact_filter_table thead .sorting:after,
            #contact_filter_table thead .sorting_asc:after,
            #contact_filter_table thead .sorting_desc:after {
                content: '';
            }

            @media print {

                a[href]:after {
                    content:"" !important;
                }
                a {
                    text-decoration: none;
                }
                .uk-table {
                    border: 1px solid black;
                    width: 100% !important;
                }
                .uk-table tr td {
                    white-space: nowrap;
                    padding: 1px 0px;
                    border: 1px solid black;
                    width: 100%;
                    font-size: 11px !important;
                }
                .uk-table tr td:first-child,
                .uk-table tr th:first-child {
                    text-align: center !important;
                }
                .uk-table tr th,
                .uk-table:last-child tr td {
                    white-space: nowrap;
                    padding: 1px 5px;
                    border: 1px solid black;
                    width: 100%;
                    font-size: 11px !important;
                }
                body {
                    margin-top: -40px;
                }

            }

            .no_display {
                display: none;
            }
    </style>
@endsection

@section('content_header')
    <div id="top_bar">
        <div class="md-top-bar">
            <ul class="uk-clearfix" id="menu_top">
                <li class="uk-hidden-small" data-uk-dropdown="">
                    <a href="#">
                        <i class="material-icons">
                            
                        </i>
                        <span>
                            Reports
                        </span>
                    </a>
                    <div class="uk-dropdown">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li>
                                Business Overview
                            </li>
                            <li>
                                <a href="{{route('report_account_profit_loss')}}">
                                    Profit and Loss
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_cash_flow_statement')}}">
                                    Cash Flow Statement
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_balance_sheet')}}">
                                    Balance Sheet
                                </a>
                            </li>
                            <li>
                                Accountant
                            </li>
                            <li>
                                <a href="{{route('report_account_transactions')}}">
                                    Account Transactions
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_general_ledger_search')}}">
                                    General Ledger
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_journal_search')}}">
                                    Journal Report
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_trial_balance_search')}}">
                                    Trial Balance
                                </a>
                            </li>
                            <li>
                                Sales
                            </li>
                            <li>
                                <a href="{{route('report_account_customer')}}">
                                    Sales by Customer
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Sales by Item
                                </a>
                            </li>
                            <li>
                                <a href="{{route('report_account_item')}}">
                                    Product Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="uk-width-medium-10-10 uk-container-center reset-print">
    <div class="uk-grid uk-grid-collapse" data-uk-grid-margin="">
        <div class="uk-width-large-10-10">
            <div class="md-card md-card-single main-print">
                <div id="invoice_preview">
                    <div class="md-card-toolbar hidden-print">
                        <div class="md-card-toolbar-actions hidden-print" style="width: 100%">

                            <div data-uk-button-radio="{target:'.md-btn'}" style="float: right; ">
                                <select data-md-selectize="" data-md-selectize-bottom="" data-uk-tooltip="{pos:'top'}" id="contact_category_dropbox" title="Select with Contact category">
                                    <option style="text-align: left;" value="">
                                        Select Contact Category...
                                    </option>
                                    <option value="all">
                                        All
                                    </option>
                                    @foreach($category as $item)
                                    <option id="contactType" value="{{ $item['id'] }}">
                                        {{ $item['contact_category_name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="float: right">
                                <input class="md-input" id="search_customer" placeholder="search customer " style="position: relative; top:-10px; width: 300px;" type="text"></input>
                            </div>
                            <i class="md-icon material-icons" id="invoice_print"></i>
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
                                    {!! Form::open(['url' => route('report_account_contact_list_search'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                        <div class="uk-modal-header">
                                            <h3 class="uk-modal-title">
                                                Select Date Range and Transaction Type
                                                <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">
                                                </i>
                                            </h3>
                                        </div>
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            @if(Auth::user()->branch_id==1)
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <label for="branch_id" style="margin-left: 10px;">
                                                        Branch
                                                    </label>
                                                    <select data-uk-tooltip="{pos:'top'}" id="branch_id" name="branch_id" style="width:400px;padding: 5px; border-top:none; border-left:none; border-right:none; border-bottom:1px solid lightgray">
                                                        <!-- <option value="">Account</option> -->
                                                        @foreach($branch as $branch_data)
                                                        <option style="z-index: 10002" value="{{$branch_data->id}}">
                                                            {{$branch_data->branch_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="uk-input-group-icon uk-icon-calendar">
                                                        </i>
                                                    </span>
                                                    <label for="uk_dp_1">
                                                        From
                                                    </label>
                                                    <input class="md-input" data-uk-datepicker="{format:'DD.MM.YYYY'}" id="uk_dp_1" name="from_date" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="uk-width-large-2-2 uk-width-2-2">
                                                <div class="uk-input-group">
                                                    <span class="uk-input-group-addon">
                                                        <i class="uk-input-group-icon uk-icon-calendar">
                                                        </i>
                                                    </span>
                                                    <label for="uk_dp_1">
                                                        To
                                                    </label>
                                                    <input class="md-input" data-uk-datepicker="{format:'DD.MM.YYYY'}" id="uk_dp_1" name="to_date" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-modal-footer uk-text-right">
                                            <button class="md-btn md-btn-flat uk-modal-close" type="button">
                                                Close
                                            </button>
                                            <button class="md-btn md-btn-flat md-btn-flat-primary" name="submit" type="submit">
                                                Search
                                            </button>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <!--end  -->
                        </div>
                        <h3 class="md-card-toolbar-heading-text large" id="invoice_name">
                        </h3>
                    </div>
                    <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                        <div class="uk-grid">
                            <div class="uk-width-small-5-5 uk-text-center">
                                <img alt="" class="logo_regular" height="15" src="{{ url('uploads/op-logo/logo.png') }}" style="margin-bottom: -20px;" width="71"/>
                                <p class="uk-text-large" style="line-height: 6px; margin-top: 35px;">
                                    {{ $OrganizationProfile->company_name }}
                                </p>
                                <p class="heading_b" id="showContactName" style="line-height: 6px;">
                                    All Contact Report
                                </p>
                                <p class="" style=" line-height: 6px;">
                                    {{ $current_branch['branch_name'] }}
                                </p>
                                @if(isset($start) && isset($end))
                                <p style="line-height: 6px;">
                                    {{ $start. " to ". $end }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="uk-grid">
                            <i class="spinner">
                            </i>
                            <div class="uk-width-1-1">
                                <table class="uk-table" id="contact_filter_table">
                                    <thead>
                                        <tr class="uk-text-upper">
                                            <th class="uk-text-center">
                                                Category
                                            </th>
                                            <th class="uk-text-left">
                                                Contact Name
                                            </th>
                                            <th class="uk-text-right">
                                                Debit
                                            </th>
                                            <th class="uk-text-right">
                                                Credit
                                            </th>
                                            <th class="uk-text-right">
                                                Balance
                                            </th>
                                            <th class="uk-text-center">
                                                Account Name
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    </tfoot>
                                    <tbody id="sortbyalpa">
                                    </tbody>
                                    <tr>
                                        <th>
                                            Total:
                                        </th>
                                        <th class="uk-text-right" id="debit">
                                        </th>
                                        <th class="uk-text-right" id="credit">
                                        </th>
                                        <th class="uk-text-right" id="balance">
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <span class="uk-text-muted uk-text-small uk-text-italic">
                                    Notes:
                                </span>
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

    <script type="text/javascript">

        var api_contact_url = "{{ route('report_account_contact_api_list_alpha_search',["index"=>'listss']) }}";

        @if(app('request')->input('from_date'))
            api_contact_url = "{{ route('report_account_contact_api_list_alpha_search',["from_date"=>app('request')->input('from_date'),"start"=>$start,"end"=>$end]) }}";
        @endif

        @if(app('request')->input('type_from'))
            api_contact_url = "{{ route('report_account_contact_api_list_alpha_search',["type_from"=>trim(app('request')->input('type_from')),"type_to"=>trim(app('request')->input('type_to'))]) }}";
        @endif

        @if(app('request')->input('contact_name'))
            api_contact_url = "{{ route('report_account_contact_api_list_alpha_search',["contact_name"=>trim(app('request')->input('contact_name'))]) }}";
        @endif

        var api_contact_details = "{{ route("report_account_single_contact_details",['id'=>'404-replace-404',"branch"=>$current_branch["id"],"start"=>$start,"end"=>$end]) }}";

        window.onload = function () {
            api_contact_url=api_contact_url.replace(/&amp;/g, '&');

            $.get(api_contact_url,function (Rcontactlist) {
              var reorderdata = [];

              $.each(Rcontactlist, function(k, v) {

                  reorderdata.push([v.category,v.display_name,v.transaction_dr.toFixed(2),v.transaction_cr.toFixed(2),v.balance.toFixed(2),v.category_id ] );
              });

              $('#contact_filter_table').DataTable({

                  "footerCallback": function ( row, data, start, end, display ) {
                      var api = this.api(), data;

                      // Remove the formatting to get integer data for summation
                      var intVal = function ( i ) {
                          return typeof i === 'string' ?
                              i.replace(/[\$,]/g, '')*1 :
                              typeof i === 'number' ?
                                  i : 0;
                      };

                      // Total over all pages
                      total_1 = api
                          .column( 2 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );


                      // Update footer
                      /*$( api.column( 2 ).footer() ).html(
                           total_1
                      );*/
                      document.getElementById("debit").innerHTML = total_1.toFixed(2);


                      // Total over all pages
                      total_2 = api
                          .column( 3 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );


                      // Update footer
                      /*$( api.column( 3 ).footer() ).html(
                          total_2
                      );*/

                      document.getElementById("credit").innerHTML = total_2.toFixed(2);

                      // Total over all pages
                      total_3 = api
                          .column( 4 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );


                      // Update footer
                      /*$( api.column( 4 ).footer() ).html(
                          total_1-total_2
                      );*/

                      document.getElementById("balance").innerHTML = (total_1-total_2).toFixed(2);

                  },
                  "paging": false,
                  "searching": false,
                  "bFilter": false,
                  "bInfo": false,
                  "bPaginate":false,
                  info: false,
                  rowReorder: {
                      enable: false
                  },

                  "order": [[ 1, "asc" ]],
                  "orderClasses": false,
                   data:reorderdata,
                  "columnDefs": [
                      { className: "no_display", "targets": [ 0 ,5] },
                      { className: "uk-text-left", "targets": [ 1 ] },
                      { className: "uk-text-right", "targets": [ 2,3,4 ] },
                      {
                          "targets": 1,
                          "render": function ( link, type, row ) {
                              var newcontact_url = api_contact_details.replace(/404-replace-404/i, row[5])
                              return "<a target='_blank' href="+newcontact_url+">"+link+"</a>";
                              return link;
                          }
                      }
                  ]
              });

              $(".spinner").remove();
          });
              sortTable(1);
        };

        $("#search_customer").on("input",function () {
           var cat_id = $(this).val().toUpperCase();
           // Declare variables
           var  filter, table, tr, td, i;

           filter = cat_id
           table = document.getElementById("contact_filter_table");
           tr = table.getElementsByTagName("tr");
           if(filter=='all')
           {
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

        function contactChangeFunction() {

            var contact_name_type = document.getElementById("contact_category_dropbox").value;

            if(contact_name_type == "1"){
                document.getElementById("showContactName").innerHTML = "Customer Due Report" ;
            }else if(contact_name_type == "2"){
                document.getElementById("showContactName").innerHTML = "Dealer Report" ;
            }else if(contact_name_type == "3"){
                document.getElementById("showContactName").innerHTML = "Employee Report" ;
            }else if(contact_name_type == "4"){
                document.getElementById("showContactName").innerHTML = "Vendor Report" ;
            }else if(contact_name_type == "5"){
                document.getElementById("showContactName").innerHTML = "Bank Report" ;
            }else if(contact_name_type == "6"){
                document.getElementById("showContactName").innerHTML = "Agent Report" ;
            }else{
                document.getElementById("showContactName").innerHTML = "All Contact Report" ;
            }
        };

        $("#contact_category_dropbox").on('change',function () {

          var cat_id = $(this).val();

          // Declare variables
          var  filter, table, tr, td, i, total_debit, total_credit, debit_value, credit_value, balance_value;

          total_debit = 0;
          total_credit = 0;

          filter = cat_id;
          table = document.getElementById("contact_filter_table");
          tr = table.getElementsByTagName("tr");

          if(filter == 'all')
          {
              for (i = 0; i < tr.length; i++) {

                  td = tr[i].getElementsByTagName("td")[0];
                  debit_value = tr[i].getElementsByTagName("td")[2];
                  credit_value = tr[i].getElementsByTagName("td")[3];
                  balance_value = tr[i].getElementsByTagName("td")[4];

                  if (td) {

                    tr[i].style.display = "";
                    total_debit = total_debit + parseFloat(debit_value.innerHTML);
                    total_credit += parseFloat(credit_value.innerHTML);

                  }
              }

              document.getElementById("debit").innerHTML = total_debit.toFixed(2);
              document.getElementById("credit").innerHTML = total_credit.toFixed(2);
              document.getElementById("balance").innerHTML = (total_debit - total_credit).toFixed(2);

            contactChangeFunction();
            return false;
          }

          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {

              td = tr[i].getElementsByTagName("td")[0];
              debit_value = tr[i].getElementsByTagName("td")[2];
              credit_value = tr[i].getElementsByTagName("td")[3];
              balance_value = tr[i].getElementsByTagName("td")[4];

              if (td) {

                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                      tr[i].style.display = "";
                      total_debit = total_debit + parseFloat(debit_value.innerHTML);
                      total_credit += parseFloat(credit_value.innerHTML);
                  } else {
                      tr[i].style.display = "none";
                  }

              }
          }

          document.getElementById("debit").innerHTML = total_debit.toFixed(2);
          document.getElementById("credit").innerHTML = total_credit.toFixed(2);
          document.getElementById("balance").innerHTML = (total_debit - total_credit).toFixed(2);

          contactChangeFunction();

        });

        function sortTable(n) {

            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("sortbyalpa");
            switching = true;

            //Set the sorting direction to ascending:
            dir = "asc";

            /*Make a loop that will continue until
             no switching has been done:*/
            while (switching) {

                //start by saying: no switching is done:
                switching = false;
                rows = table.getElementsByTagName("TR");

                /*Loop through all table rows (except the
                 first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {

                    //start by saying there should be no switching:
                    shouldSwitch = false;

                    /*Get the two elements you want to compare,
                     one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];

                    /*check if the two rows should switch place,
                     based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {

                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {

                    /*If a switch has been marked, make the switch
                     and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;

                    //Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {

                    /*If no switching has been done AND the direction is "asc",
                     set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }

            switching = false;
        }

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_reports').addClass('act_item');

    </script>

@endsection
