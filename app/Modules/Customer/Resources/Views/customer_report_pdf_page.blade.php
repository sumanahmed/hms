@extends('layouts.admin')

@section('title', ' Report')

@section('header')
    @include('inc.header')
@endsection

@section('styles')
    <style>
        #list_table_right tr td:nth-child(1){

            white-space:nowrap;
        }
        #list_table_left , #list_table_right{
           width: 100%;
           padding: 10px;

        }
        #list_table_left tr td, #list_table_right tr td{
              text-align: center;
          }
        #list_table_left tr th, #list_table_right tr th{
           border-bottom: 1px solid black;
           border-top: 1px solid black;
           font-size: 10px;
        }
        #list_table_left tr td:nth-child(1),#list_table_left tr td:last-child,#list_table_left tr th:last-child,#list_table_right tr td:last-child{

            white-space:nowrap;
        }
        @media print {
            #list_table_left , #list_table_right{
              border:none;
             font-size: 11px !important;

            }
            #list_table_right{
                margin-left: 10px;
            }
            body{
                margin-top: -40px;
            }
            #total, #table_close,#table_open,#list_table_left,#list_table_right{
                font-size: 11px !important;
            }
            .md-card-toolbar{
                display: none;
            }

            #list_table_left tr th:nth-child(6) {
                display: none;
            }
            #list_table_right tr th:nth-child(6) {
                display: none;
            }
            #list_table_left tr td:nth-child(6) {
                display: none;
            }
            #list_table_right tr td:nth-child(6) {
                display: none;
            }

        }
    </style>
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')
<div class="uk-width-medium-10-10 uk-container-center reset-print" >
    <div class="uk-grid uk-grid-collapse" >
        <div class="uk-width-large-10-10" >
            <div class="md-card md-card-single main-print">
                <div id="invoice_preview hidden-print">
                    <div class="md-card-toolbar hidden-print">
                        <div class="md-card-toolbar-actions hidden-print">
                            <i class="md-icon material-icons" id="invoice_print"></i>


                           
                            <!--end  -->
                            <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}" aria-haspopup="true" aria-expanded="true"> <a href="#" data-uk-modal="{target:'#coustom_setting_modal'}"><i class="material-icons">&#xE8B8;</i><span>Custom Setting</span></a>
                                
                            </div>
                            <!--coustorm setting modal start -->
                            <div class="uk-modal" id="coustom_setting_modal">
                                <div class="uk-modal-dialog">
                                {!! Form::open(['url' => 'recruitreport/mofa-report', 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'user_profile']) !!}
                                    <div class="uk-modal-header">
                                        <h3 class="uk-modal-title">Select Date Range and Transaction Type <i class="material-icons" data-uk-tooltip="{pos:'top'}" title="headline tooltip">&#xE8FD;</i></h3>
                                    </div>

                                   
                                    <div class="uk-width-large-2-2 uk-width-2-2">
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-input-group">
                                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                <label for="uk_dp_1">Form</label>
                                                <input class="md-input" type="text" id="uk_dp_1" name="from_date" data-uk-datepicker="{format:'YYYY-MM-DD'}" 
                                            >
                                            </div>
                                        </div>
                                        <div class="uk-width-large-2-2 uk-width-2-2">
                                            <div class="uk-input-group">
                                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                                <label for="uk_dp_1">To</label>
                                                <input class="md-input" type="text" id="uk_dp_1" name="to_date" data-uk-datepicker="{format:'YYYY-MM-DD'}" >
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
                                <img style="margin-bottom: -20px;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/>                               
                                <p style="line-height: 5px; margin-top: 35px;" " class="heading_b uk-text-success">Customer Report</p> 
                                <p style="line-height: 5px; class="uk-text-large">Pax ID : {!!$recruit_order->paxid !!}</p>
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr  class="uk-text-upper" >
                                        <th colspan="2" style="font-size: 10px">ACCOUNT INFO</th>
                                    </tr>
                                    </thead>
                                        <tbody class="uk-text-center">
                                            

                                          <tr>
                                             <td col= "1"  width= "50%" >Total Recievable : @if(isset($totalamount->total_amount))
                                                {{ $totalamount->total_amount }}
                                            @else
                                                000
                                            @endif </td>

                                              <td col= "2"  width= "50%" > Total Recieved : @php
                                                     $total =000;
                                                 @endphp
                                            @foreach($payment_entry as $value)
                                                @php

                                                    $total+=$value->amount;
                                                @endphp


                                            @endforeach
                                            @if($total==0)
                                                000
                                            @else
                                                {{ $total }}
                                            @endif
                                                 </td>
                                          </tr>
                                          <tr>
                                              <td col= "1"  width= "50%" > Total Due : @php
                                                    if(isset($totalamount->total_amount)){
                                                     $due= $totalamount->total_amount - $total;
                                                    }else{
                                                    $due = "000";
                                                    }

                                                @endphp
                                            {{ $due }}
                                                 </td>
                                              <td col= "2"  width= "50%" >Total Expense : {{ $expense }}</td>
                                          </tr>
                                      </tbody>
                                   </table> 
                            </div>
                        </div>
                        
                        <div class="uk-grid" >
                                
                            <div  class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                
                                        <th colspan="2" style="font-size: 10px">GENERAL  INFO</th>                                                 

                                    </tr>
                                    </thead>
                                       <tbody >
                                
                                             <trclass="uk-text-center" >
                                  
                                                 <td  col= "1"  width= "50%"  >Pax ID : {!!$recruit_order->paxid !!}</td>
                                                 <td  col= "2"  width= "50%"  >Passenger Name : {!!$recruit_order->passenger_name !!}</td>
                                              </tr>
                                              <tr class="uk-text-center" >
                                                 <td  col= "1"  width= "50%"  >Reference : {{ $recruit_order->customer['display_name'] }}</td>
                                                 <td  col= "2"  width= "50%"  >Visa (bill) : {{ $recruit_order->registerserial['registerSerial'] }}
                                                     @if($recruit_order->bill)
                                                         (BILL-{{ $recruit_order->bill['bill_number'] }})
                                                     @endif
                                                 </td>
                                              </tr>
                                              <tr class="uk-text-center">
                                                 <td  col= "1"  width= "50%"   > Order(Invoice Number) : {{ date('d-m-Y', strtotime($recruit_order->created_at)) }}
                                                     @if($recruit_order->invoice)
                                                         ( INV-{{ $recruit_order->invoice['invoice_number'] }})
                                                     @endif
                                                 </td> 
                                              </tr>

                                          </tbody>
                                      </table>                                  
                                
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan="2" style="font-size: 10px">MEDICAL AND CLEARANCE</th>
                                    </tr>
                                    </thead>
                                      <tbody class="uk-text-center" >  
                                      <tr>   
                                             <td col= "1"  width= "50%"  >Report : {{ $recruit_order->medical_slip["medical_report_date"] }} </td>

                                              <td col= "2"  width= "50%"  >Mofa : {{ $recruit_order->mofas["mofaDate"] }}
                                                 </td>
                                        </tr>
                                        <tr>
                                              <td col= "1"  width= "50%"  > Fit Card : {{ $recruit_order->fitcard["receive_date"] }}
                                                 </td>
                                              <td col= "2"  width= "50%"  >Police Clearance : {{ $recruit_order->police?$recruit_order->police->submission_date:'' }}</td>
                                        </tr>
                                    </tbody>
                                   </table>  
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan= "2" style="font-size: 10px">STAMPING</th>
                                                                  
                                    </tr>
                                    </thead>
                                <tbody class="uk-text-center" >
                                  <tr>
                                            <td col= "1" width= "50%" > Outgoing : {{ $recruit_order->visas["send_date"] }}  </td>
                                            <td col= "2" width= "50%"> Incoming : {{ $recruit_order->visas["return_date"] }}  </td>
                                  </tr>

                                   </tbody>
                                   </table>
                                
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan="2"  style="font-size: 10px">MANPOWER</th>   
                                                                 
                                    </tr>
                                    </thead>
                                       <tbody>
                                        <tr>

                                                 <td col= "1"  width= "50%"> Finger : {{ $recruit_order->finger['assignedDate'] }}
                                                 </td>
                                                 <td col= "2"  width= "50%"> Training : {{ $recruit_order->training['received_date'] }} </td>
                                            </tr>
                                            <tr>

                                                 <td col= "1"  width= "50%" > Manpower : {{ $recruit_order->manpower['issuingDate'] }}</td>
                                                 <td col= "2"  width= "50%" > Completion : {{ $recruit_order->completion['date'] }}</td>
                                            </tr>
                                      </tbody>
                                    </table>

                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan="2" style="font-size: 10px">FLIGHT</th>
                                                                 
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                               
                                             <td col= "1"  width= "50%"   > Submission : {{ $recruit_order->submission['submission_date'] }} </td>
                                             <td col= "2"  width= "50%"  > Confirmation : {{ $recruit_order->confirmation['date_of_flight'] }} </td>
                                           </tr>
                                    </tbody>
                                 </table>
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan="2"  style="font-size: 10px">IQAMA</th>
                                    </tr>
                                    </thead>
                                         <tr>

                                             <td col= "1"  width= "50%"   > Insurance : {{ $recruit_order->insurance['date_of_payment']?date("Y-m-d",strtotime($recruit_order->insurance['date_of_payment'])):'' }}</td>
                                             <td col= "1"  width= "50%"  > Submission : {{ $recruit_order->iqamaSubmission['submission_date']?date("Y-m-d",strtotime($recruit_order->iqamaSubmission['submission_date'])):'' }}</td>
                                        </tr>
                                        <tr>
                                             <td col= "1"  width= "50%"  > Receive : {{ $recruit_order->iqamaReceive['receive_date']?date("Y-m-d",strtotime($recruit_order->iqamaReceive['receive_date'])):'' }}</td>

                                             <td col= "1"  width= "50%"  >Recipient : {{ $recruit_order->reciepient['recipient_name'] }}</td>
                                          </tr>
                                     </tbody>           
                               </table>
                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left">
                                    <thead>
                                    <tr class="uk-text-upper">
                                        <th colspan="2" style="font-size: 10px">KAFALA</th>
                                                                 
                                    </tr>
                                    </thead>
                               
                                            <tr>
                                                <td col= "1"  width= "50%"  >Before 60 days : {{ $recruit_order->beforeSixtyDays['date_of_kafala']?date("Y-m-d",strtotime($recruit_order->beforeSixtyDays['date_of_kafala'])):'' }}</td>
                                                <td col= "1"  width= "50%"  >After 60 days : {{ $recruit_order->afterSixtyDays['receive_date']?date("Y-m-d",strtotime($recruit_order->afterSixtyDays['receive_date'])):'' }}</td>
                                              </tr>
                                    </tbody>
                                   </table>

                            </div>
                        </div>

                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table id="list_table_left" >
                                <thead>
                                <tr>
                                    <th width="12%" style="text-align: left;">INCOME</th>

                                </tr>
                                <tr>
                                    <th width="12%" style="font-size: 10px">DATE</th>
                                    <th width="22%" style="font-size: 10px">PARTICULARS</th>
                                    <th width="22%" style="font-size: 10px">FOLIO/RCT.NO</th>
                                    <th width="22%" style="font-size: 10px">Amount</th>
                                    <th width="22%" style="font-size: 10px">Total Amount</th>
                                </tr>
                                </thead>

                             @php
                             if(isset($totalamount->total_amount)){
                              $temptotal =$totalamount->total_amount;
                             }else{
                             $temptotal = 0;
                             }

                             @endphp

                                <tbody>
                                @foreach($payment_entry as $value)
                                    @php
                                        $temptotal =$temptotal - $value->amount;
                                    @endphp
                                <tr>
                                    <td  class="uk-text-center">{{ date("d-m-Y", strtotime($value->created_at)) }}</td>
                                    <td  class="uk-text-left">{{ $value->paymentReceive->note }}</td>
                                    <td  class="uk-text-center">PR-{{ decbin($value->id) }}</td>
                                    <td  class="uk-text-center">{{ $value->amount }}</td>
                                    <td  class="uk-text-center">{{ $temptotal }}</td>
                                  
                                </tr>
                               @endforeach
                                </tbody>
                            </table>

                            </div>
                        </div>


                        <div class="uk-grid" >
                                
                            <div id="list_table_left_parent" class="uk-width-1-1" style="font-size: 12px;">
                                
                                <table  id="list_table_left" >
                                   <thead>
                                <tr>
                                    <th width="12%" style="text-align: left;">EXPENSE</th>

                                </tr>
                              </thead>
                                <thead>

                                <tr>
                                    <th width="12%" style="font-size: 10px">SERIAL</th>
                                    <th width="22%" style="font-size: 10px">DATE</th>
                                    <th width="22%" style="font-size: 10px">SECTOR</th>
                                    <th width="22%" style="font-size: 10px">VENDOR</th>
                                    <th width="22%" style="font-size: 10px">Amount</th>
                                </tr>
                                </thead>


                                <tbody id="expense">
                                @php
                                    $con = new Helpers();
                                   $Customerexpense  = new App\Lib\Customerexpense();
                                @endphp

                                @foreach ($recruitexpensepax as $value)

                                    @if(isset($value->RecruiteExpense->expense_id))
                                   @php
                                       $var1 = $Customerexpense->RecruitExpense($value->recruitExpenseid);
                                       $var2 = $Customerexpense->var2($value->recruitExpenseid, $value->paxid);
                                   @endphp
                                   @if(isset($value->RecruiteExpense->amount->amount))
                                    <tr>
                                        <td width="12%" class="uk-text-center"></td>
                                        <td width="22" class="uk-text-center">{{ date("d-m-Y", strtotime($value->created_at)) }}</td>
                                        <td width="22%" class="uk-text-center"> {{ $value->RecruiteExpense->Sector->title }}</td>
                                        <td width="22%" class="uk-text-center"> {{ $con->getCustomerName($value->RecruiteExpense->amount->vendor_id) }}</td>
                                        <td width="22%" class="uk-text-center"> {{ round($value->RecruiteExpense->amount->amount*$var2/$var1,3) }}</td>
                                       
                                    </tr>
                                     @endif

                                    @endif
                                 @endforeach

                                </tbody>
                            </table>

                            </div>
                        </div>

                        



                        <br></br><br></br>
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
    <!-- handlebars.js -->
<script src="{{ url('admin/bower_components/handlebars/handlebars.min.js')}}"></script>
<script src="{{ url('admin/assets/js/custom/handlebars_helpers.min.js')}}"></script>

<script src="{{ url('admin/assets/js/kendoui_custom.min.js')}}"></script>
    <!--  kendoui functions -->
<script src="{{ url('admin/assets/js/pages/kendoui.min.js')}}"></script>

<!--  invoices functions -->
<script src="{{ url('admin/assets/js/pages/page_invoices.min.js')}}"></script>
<script type="text/javascript">

    $("#invoice_print").click(function(){
       $("#list_table_right").removeClass('uk_table');
       $("#list_table_left").removeClass('uk_table');
    });

    $('#sidebar_recruit').addClass('current_section');
    $('#sidebar_customer_report').addClass('act_item');
</script>
 <script>
         function totalExpense()
         {
             var expense_num = document.getElementById("expense_num").innerText;

             var oTable = document.getElementById("expense");

             var rowLength = oTable.rows.length;
             var sum = 0;            //loops through rows
             for (i = 0; i < rowLength; i++){

                 //gets cells of current row
                 var oCells = oTable.rows[i].cells[4].innerText;

                 sum =sum+ parseFloat(oCells);

             }
             document.getElementById("expense_num").innerText = sum;



         }
         window.onload = function(){ totalExpense(); };

         $('#sidebar_recruit').addClass('current_section');
         $('#sidebar_customer').addClass('act_item');
         $('.customer_account').addClass('md-bg-blue-grey-100');
      </script>
@endsection
