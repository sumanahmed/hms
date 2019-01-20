@extends('layouts.admin')

@section('title', 'Customer Dashboard')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection



@section('content')
    <div class="uk-width-large-10-10">

        <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
            @include('inc.customer_nav')

            <div class="uk-width-xLarge-8-10  uk-width-large-8-10">

                    <div  class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                        <div>
                            <div class="md-card">
                                <div class="md-card-content">

                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
                                    <span class="uk-text-muted uk-text-small">Total Recievable</span>
                                    <h2 class="uk-margin-remove">‎৳ <span class="countUpMe">
                                                @if(isset($totalamount->total_amount))
                                                {{ $totalamount->total_amount }}
                                            @else
                                                000
                                            @endif
                                            </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="md-card">
                                <div class="md-card-content">
                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                                    <span class="uk-text-muted uk-text-small">Total Recieved</span>
                                    <h2 class="uk-margin-remove">‎৳
                                        <span class="countUpMe">
                                                 @php
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
                                            </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="md-card">
                                <div class="md-card-content">
                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                                    <span class="uk-text-muted uk-text-small">Total Due</span>
                                    <h2 class="uk-margin-remove">‎৳ <span class="countUpMe">
                                                @php
                                                    if(isset($totalamount->total_amount)){
                                                     $due= $totalamount->total_amount - $total;
                                                    }else{
                                                    $due = "000";
                                                    }

                                                @endphp
                                            {{ $due }}
                                            </span></h2>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="md-card">
                                <div class="md-card-content" onload="totalExpense();">
                                    <div  class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                                    <span class="uk-text-muted uk-text-small">Total Expense</span>
                                    <h2 class="uk-margin-remove">‎৳ <span id="expense_num" class="countUpMe">{{ $expense }}</span></h2>
                                </div>
                            </div>
                        </div>

                    </div>


                <div class="md-card">

             <div class="md-card-content">
                 <div class="uk-grid" data-uk-grid-margin>

                     <div class="uk-width-medium-1-1">
                       


                             <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                                     <li class="uk-active"><a href="#">Genaral</a></li>
                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">

                                                 <td>Pax ID</td>
                                                 <td>Passenger Name</td>
                                                 <td>Reference</td>
                                                 <td>Visa (bill)</td>
                                                 <td>Order(Invoice Number)</td>
                                             </tr>
                                             <tr>
                                                 <td>{!!$recruit_order->paxid !!}</td>
                                                 <td>{!!$recruit_order->passenger_name !!}</td>
                                                 <td>{{ $recruit_order->customer['display_name'] }}</td>
                                                 <td>{{ $recruit_order->registerserial['registerSerial'] }}
                                                     @if($recruit_order->bill)
                                                         (BILL-{{ $recruit_order->bill['bill_number'] }})
                                                     @endif
                                                 </td>
                                                 <td>{{ date('d-m-Y', strtotime($recruit_order->created_at)) }}
                                                     @if($recruit_order->invoice)
                                                         ( INV-{{ $recruit_order->invoice['invoice_number'] }})
                                                     @endif
                                                 </td>

                                             </tr>
                                         </table>


                                     </li>
                                
                                 </ul>

                             </div>


                                 <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }" style="list-style-type: none;">
                            
                                     <li><a href="#">Medical & Clearance</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     
                                     <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">


                                                 <td>Report</td>
                                                 <td>Mofa</td>
                                                 <td>Fit Card</td>
                                                 <td>Police Clearance</td>
                                             </tr>
                                             <tr>


                                                 <td>
                                                   {{ $recruit_order->medical_slip["medical_report_date"] }}
                                                 </td>

                                                 <td>
                                                  {{ $recruit_order->mofas["mofaDate"] }}
                                                 </td>
                                                 <td>
                                                  {{ $recruit_order->fitcard["receive_date"] }}
                                                 </td>
                                                 <td>{{ $recruit_order->police?$recruit_order->police->submission_date:'' }}</td>

                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>



                             <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                            
                                     <li><a href="#">Stamping</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     
                                      <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">

                                                 <td>Outgoing</td>
                                                 <td>Incoming</td>

                                             </tr>
                                             <tr>
                                              <td> {{ $recruit_order->visas["send_date"] }}  </td>
                                              <td> {{ $recruit_order->visas["return_date"] }}  </td>
                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>

                             <div class="md-card-content" >
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                            
                                     <li><a href="#">Manpower</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     
                                     <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">

                                                 <td>Finger</td>
                                                 <td>Training</td>
                                                 <td>Manpower</td>
                                                 <td>Completion</td>
                                             </tr>
                                             <tr>

                                                 <td>{{ $recruit_order->finger['assignedDate'] }}<br>

                                                 </td>
                                                 <td>{{ $recruit_order->training['received_date'] }}<br>

                                                 </td>
                                                 <td>{{ $recruit_order->manpower['issuingDate'] }}</td>
                                                 <td>{{ $recruit_order->completion['date'] }}</td>
                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>

                             <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                            
                                     <li><a href="#">Flight</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     
                                     <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">
                                                 <td>Submission</td>
                                                 <td>Confirmation</td>
                                             </tr>
                                             <tr>
                                             <td> {{ $recruit_order->submission['submission_date'] }} </td>
                                             <td> {{ $recruit_order->confirmation['date_of_flight'] }} </td>

                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>

                             <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                            
                                      <li><a href="#">Iqama</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                      
                                     <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">

                                                 <td>Insurance</td>
                                                 <td>Submission</td>
                                                 <td>Receive</td>
                                                 <td>Recipient</td>

                                             </tr>
                                             <tr>
                                             <td>{{ $recruit_order->insurance['date_of_payment']?date("Y-m-d",strtotime($recruit_order->insurance['date_of_payment'])):'' }}</td>
                                             <td>{{ $recruit_order->iqamaSubmission['submission_date']?date("Y-m-d",strtotime($recruit_order->iqamaSubmission['submission_date'])):'' }}</td>
                                             <td>{{ $recruit_order->iqamaReceive['receive_date']?date("Y-m-d",strtotime($recruit_order->iqamaReceive['receive_date'])):'' }}</td>

                                             <td>{{ $recruit_order->reciepient['recipient_name'] }}</td>
                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>

                             <div class="md-card-content">
                                 <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                            
                                     <li><a href="#">Kafala</a></li>
                                  

                                 </ul>
                                 <ul id="settings_users"  style="list-style-type: none;">
                                     
                                      <li>
                                         <table class="uk-table">
                                             <tr style="background-color: #073642; color: white">
                                                 <td>Before 60 days</td>
                                                 <td>After 60 days</td>
                                             </tr>
                                             <tr>
                                                <td>{{ $recruit_order->beforeSixtyDays['date_of_kafala']?date("Y-m-d",strtotime($recruit_order->beforeSixtyDays['date_of_kafala'])):'' }}</td>
                                                <td>{{ $recruit_order->afterSixtyDays['receive_date']?date("Y-m-d",strtotime($recruit_order->afterSixtyDays['receive_date'])):'' }}</td>
                                             </tr>
                                         </table>
                                     </li>
                                     
                                 </ul>
                             </div>



                             <div class="md-card-content">
                                 <ul id="settings_users"  style="list-style-type: none;padding: 50 px;">
                                     
                                     <li style="text-align: center; background-color: #073642; color: #ffffff; padding: 12px">
                                       <a href="{{route('customer_download_report_pdf', $recruit_order->paxid )}}">Download</a>

                                     </li>

                                     
                                 </ul>
                             </div>

                     </div>
                 </div>



            </div>
            <hr>
            
        </div>
            </div>
        </div>
    </div>
    <script>

        function deleterow(link) {
            UIkit.modal.confirm('Are you sure?', function(){
                window.location.href = link;
            });
        }
    </script>
@endsection

@section('scripts')
    <script>


        $(window).load(function(){
            $('#sidebar_recruit').addClass('current_section');
            $('#sidebar_customer').addClass('act_item');
            $('.customer_mosaned').addClass('md-bg-blue-grey-100');

            setTimeout(function () {
                $("#sidebar_main_toggle").trigger('click');
            },3000);
        })
    </script>
@endsection