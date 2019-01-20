@extends('layouts.main')

@section('title', 'Dashboard')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')

    <div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler" data-uk-grid-margin="" data-uk-sortable="">
        <div class="uk-row-first" style="">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right">
                        <span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span>
                    </div>

                    <h2 class="uk-margin-remove"><span class="countUpMe">38</span></h2>
                    <span class="uk-text-muted uk-text-small">Today Patient</span>
                </div>
            </div>
        </div>

        <div style="">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right">
                        <span class="peity_orders peity_data">64/100</span>
                    </div>

                    <h2 class="uk-margin-remove"><span class="countUpMe">790</span></h2>
                    <span class="uk-text-muted uk-text-small">Total Admitted Patient</span>
                </div>
            </div>
        </div>

        <div style="">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right">
                        <span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span>
                    </div>

                    <h2 class="uk-margin-remove" id="peity_live_text">805</h2>
                    <span class="uk-text-muted uk-text-small">Successfully Discharged</span>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler" data-uk-sortable="" data-uk-grid-margin="" style="">
        <div style="" class="uk-row-first">
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Total Doctors</span>
                    <h2 class="uk-margin-remove"><span class="countUpMe">45</span></h2>
                </div>
            </div>
        </div><div style="" class="">
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Total Nurse</span>
                    <h2 class="uk-margin-remove"><span class="countUpMe">160</span></h2>
                </div>
            </div>
        </div><div style="" class="">
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Total Ward</span>
                    <h2 class="uk-margin-remove" id="peity_live_text">8</h2>
                </div>
            </div>
        </div><div class="" style="">
            <div class="md-card">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Total Bad</span>
                    <h2 class="uk-margin-remove"><span class="countUpMe">4604</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="pricing_table pricing_table_a uk-grid uk-grid-small uk-grid-width-medium-1-2 uk-grid-width-large-1-2 uk-margin-large-bottom" data-uk-grid-margin="" data-uk-grid-match="{target:'.md-card-content'}">

        <div class="uk-row-first">
            <div class="md-card payment">
                <div class="md-card-content padding-reset" style="min-height: 177px;">
                    <div style="" class="pricing_table_plan md-bg-green-500 md-color-white">Pending Test Report</div>
                    <div class="pricing_table_price">
                        40
                        <span class="period">Total 100</span>
                    </div>

                </div>
            </div>
        </div>
        <div>
            <div class="md-card payment">
                <div class="md-card-content padding-reset" style="min-height: 177px;">
                    <div class="pricing_table_plan md-bg-green-500 md-color-white">Completed  Test Report</div>
                    <div class="pricing_table_price">
                        60
                        <span class="period">Total 100</span>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{!! asset('admin/assets/js/custom/datatables/dataTables.scroller.min.js') !!}"></script>
    <script type="text/javascript">
        var overdue = "{{ route("dashboard_overDueReceivable_api") }}";
        var invoice_route = "{{ route('dashboard_overDueReceivable_invoice_show_api',["id"=>'']) }}";
        var reorder = "{{ route("dashboard_reorder_list_api") }}";
        var inventory_route = "{{ route('inventory_show',["id"=>'']) }}";
        var overdue_pay = "{{ route("dashboard_overduePayable_list_api") }}";
        var overdue_pay_bill = "{{ route('purchase_invoice_show',["id"=>'']) }}";


          window.onload = function () {
              $.get(overdue,function (datalist) {
                  var data = [];
                    $.each(datalist, function(k, v) {
                      data.push([v.id, v.due_amount, v.payment_date ] );
                  });


                  $('#data_table_1').DataTable({
                      "pageLength": 50,
                      data:           data,
                      deferRender:    false,
                      scrollY:        200,
                      scrollCollapse: true,
                      scroller:       true,
                      "columnDefs": [
                          {
                              "targets": 0,
                              "render": function ( link, type, row ) {
                                      return "<a target='_blank' href="+invoice_route+"/"+link+">"+"INV-"+padLeft(link,6)+"</a>";
                                  return link;
                              }
                          }
                      ]
                  });
              });
              // overdue payable
              $.get(overdue_pay,function (overduelist) {
                  var overduedata = [];
                  $.each(overduelist, function(k, v) {

                      overduedata.push([v.id, v.due_amount, v.due_date,v.bill_number ] );
                  });
                  $('#data_table_2').DataTable({
                      "pageLength": 50,
                      data:           overduedata,
                      deferRender:    false,
                      scrollY:        200,
                      scrollCollapse: true,
                      scroller:       true,
                      "columnDefs": [
                          {
                              "targets": [ 3 ],
                              "visible": false
                          },
                          {
                              "targets": 0,

                              "render": function ( link, type, row ) {

                                  return "<a target='_blank' href="+overdue_pay_bill+"/"+link+">"+"BILL-"+padLeft(link,6)+"</a>";
                                  return link;
                              }
                          }
                      ]
                  });
              });

              
              //reorder

              $.get(reorder,function (reorderlist) {
                  var reorderdata = [];
                    $.each(reorderlist, function(k, v) {

                      reorderdata.push([v[1], v[0],k ] );
                  });
                  $('#data_table_5').DataTable({
                      "pageLength": 30,
                      data:reorderdata,

                      "columnDefs": [
                          {
                              "targets": [ 2 ],
                              "visible": false
                          },
                          {
                              "targets": 0,
                              "render": function ( link, type, row ) {

                                return "<a target='_blank' href="+inventory_route+"/"+row[2]+">"+row[0]+"</a>";

                              }
                          }
                      ]
                  });
              });


          }
        var accordion = UIkit.accordion(document.getElementById('accor'), {
            showfirst:false

        });


        $('#data_table_3').DataTable({
            "pageLength": 50
        });
        $('#data_table_4').DataTable({
            "pageLength": 50
        });

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_dashboard').addClass('act_item');
        function padLeft(nr, n, str){
            return Array(n-String(nr).length+1).join(str||'0')+nr;
        }
    </script>
@endsection