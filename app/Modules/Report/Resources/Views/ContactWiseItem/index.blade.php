@extends('layouts.admin')

@section('title', 'Products Sold Report '.date("Y-m-d h-i-sa"))

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
                content:"" !important;

            }
            a{
                text-decoration: none;
            }
            .uk-table{
                border: 1px solid black;
                width: 100% !important;
            }
            .uk-table tr td{
                white-space: nowrap;
                padding: 1px 0px;
                border: 1px solid black;
                width: 100%;
                font-size: 11px !important;
            }
            .uk-table tr td:first-child,.uk-table tr th:first-child{
                text-align: center !important;
            }
            .uk-table tr th ,.uk-table:last-child tr td{

                white-space: nowrap;
                padding: 1px 5px;
                border: 1px solid black;

                width: 100%;
                font-size: 11px !important;
            }

            body{
                margin-top: -40px;
            }
        }
        .no_display{
            display: none;
        }



        .md-card-dropdown
        {
            padding-top: 15px;
        }
</style>
@endsection
@section('content')
<div class="uk-width-medium-10-10 uk-container-center reset-print">
    <div class="uk-grid uk-grid-collapse" data-uk-grid-margin="">
        <div class="uk-width-large-10-10">
            <div class="md-card md-card-single main-print">
                <div id="invoice_preview">
                    <div class="md-card-toolbar hidden-print">
                        <div class="md-card-toolbar-actions hidden-print" style="width: 100%">
                            <i class="md-icon material-icons" id="invoice_print">
                                
                            </i>
                        
                            {{-- Category --}}
                            <div>
                                <select data-md-selectize="" data-md-selectize-bottom="" data-uk-tooltip="{pos:'top'}" id="contact_category_dropbox" onchange="contactChangeFunction()" title="Select with Contact category">
                                    <option value="">
                                        Category   
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
                        
                            
                            <!--end  -->
                        </div>
                    </div>
                    <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                        {{-- Title --}}
                        <div class="md-card-content invoice_content print_bg" style="height: 100%;">
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-small-5-5 uk-text-center">
                                    <img alt="" class="logo_regular" height="15" src="{{ url('uploads/op-logo/logo.png') }}" width="71"/>
                                    <p class="uk-text-large" style="line-height: 6px; margin-top: 15px;">
                                        {{ $OrganizationProfile->company_name }}
                                    </p>
                                    <p class="heading_b" id="showContactName">
                                        Items Sold/Purchased By Contact
                                    </p>
                                    <p class="uk-text-small" style="line-height: 5px;">
                                        From {{$start}} To {{$end}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- table --}}
                        <div class="uk-grid uk-margin-large-bottom">
                            <div class="uk-width-1-1">
                                <table class="uk-table" id="contact_filter_table">
                                    <thead>
                                        <tr class="uk-text-upper">
                                            <th class="no_display">
                                                Category
                                            </th>
                                            <th>
                                                Contact Name
                                            </th>
                                            <th class="uk-text-right">
                                                Total Sales
                                            </th>
                                            <th class="uk-text-right">
                                                Total Purchase
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_sales=0; $total_purchase=0;@endphp
                                        @foreach($data as $b)
                                        <tr>
                                            <td class="no_display">
                                                {{$b['category']}}
                                            </td>
                                            <td>
                                                <a href="{{ route('show_details_contact_wise_report' ,[$b['id'], $start, $end ]) }}">
                                                    {{ $b['name']}}
                                                </a>
                                            </td>
                                            <td class="uk-text-right">
                                                @if($b['total_sales']>0)
                                                @php $total_sales+=$b['total_sales'];@endphp
                                                {{number_format($b['total_sales'], 2)}}
                                                @endif
                                            </td>
                                            <td class="uk-text-right">
                                                @if($b['total_purchase']>0)
                                                @php $total_purchase+=$b['total_purchase']; @endphp
                                                {{number_format( $b['total_purchase'], 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="no_display">
                                            </td>
                                            <td class="uk-text-large">
                                                <b>
                                                    Total
                                                </b>
                                            </td>
                                            <td class="uk-text-right">
                                                {{$total_sales>0?number_format( $total_sales, 2):""}}
                                            </td>
                                            <td class="uk-text-right">
                                                {{$total_purchase>0?number_format( $total_purchase, 2):""}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Notes --}}
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
<script src="{{ url('admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript">
    <script src="{{ url('admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript">
    window.onload = function () {         

            
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

          contactChangeFunction();



          // Declare variables
          var  filter, table, tr, td, i, total_debit, total_credit, debit_value, credit_value;

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
