@extends('layouts.main')

@section('title', 'Receive Undelivered')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')
    <div class="uk-grid">
        <div class="uk-width-large-10-10">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-10-10 uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Purchase New Invoice</span></h2>
                            </div>
                        </div>
                        <div class="user_content">

                            <div class="uk-grid">

                                <div class="uk-width-medium-1-2 uk-row-first">
                                    <div class="uk-form-row">

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5  uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="company_id">Company<span style="color: red;" class="asterisc">*</span></label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <select class="form-control" title="Select Company" id="company_id" name="company_id" required>
                                                    <option value="">Select Company</option>
                                                    @foreach($company as $value)
                                                        <option value="{{ $value->id }}">{{ $value->serial." ".$value->display_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1 uk-margin-top">
                                                <table class="uk-table">
                                                    <thead>
                                                        <th>Name</th>
                                                        <th>Qty</th>
                                                        <th>Rate</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody class="show_row">

                                                    </tbody>
                                                    <tr class="total_value_tr" style="display: none;">
                                                        <td colspan="2"></td>
                                                        <td>Total Value</td>
                                                        <td id="totalValue"></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="uk-width-medium-1-2" id="show_item_details" style="display: none;">
                                    {!! Form::open(['url' => route('recevie_undelivered_update'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                                        <div class="uk-form-row">
                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2 md-input-filled">
                                                    <label for="received_date">Received Date</label>
                                                    <input class="md-input" type="text" id="received_date" name="received_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="received_date">Company</label>
                                                    <input class="md-input" type="text" id="company_name" name="company_name" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="product_code">Item Code</label>
                                                    <input class="md-input" type="text" id="product_code" name="product_code" value="">
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="item_name">Item Name</label>
                                                    <input class="md-input" type="text" id="item_name" name="item_name" value="">
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="purchase_price">Purchase Price</label>
                                                    <input class="md-input" type="text" id="purchase_price" name="purchase_price" value="" readonly>
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="undelivered_quantity">Undelivered Quantity</label>
                                                    <input class="md-input" type="text" id="undelivered_quantity" name="undelivered_quantity" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="purchase_price">Value</label>
                                                    <input class="md-input" type="text" id="value" name="value" value="" readonly>
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="received_quantity">Received Quantity</label>
                                                    <input class="md-input" type="text" id="received_quantity" name="received_quantity" value="">
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="saleable_stock">Saleable Stock</label>
                                                    <input class="md-input" type="text" id="saleable_stock" name="saleable_stock" value="" readonly>
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="current_stock">Current Stock</label>
                                                    <input class="md-input" type="text" id="current_stock" name="current_stock" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-2">
                                                    <label for="current_undelivered_quantity">Current Undelivered Quantity</label>
                                                </div>
                                                <div class="uk-width-medium-1-2">
                                                    <input class="md-input" type="text" id="current_undelivered_quantity" name="current_undelivered_quantity" value="" readonly>
                                                </div>
                                            </div>

                                            <input type="hidden" name="bill_id" id="bill_id" value="">
                                            <input type="hidden" name="item_id" id="item_id" value="">

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-1-1 uk-float-left">
                                                    <button type="submit" class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" value="Submit" name="submit">Submit</button>
                                                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    {!! Form::close() !!}
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
        $(document).ready(function() {

            //Get product by select company
            $('#company_id').change(function() {

                var company_id = $("#company_id option:selected").val();

                if(company_id != null){
                    var total_amount    = 0;
                    $.get('/receive-undelivered/ajax-item/'+ company_id, function(data){

                        $('.show_row').empty();

                        for(var i =0; i< data.length; i++){

                            total_amount +=  (data[i].quantity * data[i].item_purchase_rate);

                            $('.show_row').append(
                                '<tr>\n' +
                                '    <td>'+data[i].item_name+'</td>\n' +
                                '    <td>'+data[i].quantity+'</td>\n' +
                                '    <td>'+data[i].item_purchase_rate+'</td>\n' +
                                '    <td>'+(data[i].quantity * data[i].item_purchase_rate) +'</td>\n' +
                                '    <td><a onclick="showItemDetails('+data[i].id+","+data[i].company_id+')" class="show_div"><i title="Edit" class="material-icons">&#xE254;</i></a></td>\n' +
                                '</tr>' );

                            $(".total_value_tr").show();
                            $("#totalValue").text(total_amount);

                        }
                    });
                }
            });

        });
    </script>

    <script>
        function showItemDetails(item_id, company_id) {
            $("#show_item_details").show();
            $.get('/receive-undelivered/ajax-undelivered-item/'+ item_id+"/"+company_id, function(data){

                var item_total_purchase     =  data.total_purchases == null ? data.total_purchases : 0;
                var item_total_sales        =  data.total_sales == null ? data.total_sales : 0;
                var current_stock           =  (item_total_purchase - item_total_sales);


                $("#company_name").val(data.company_name);
                $("#product_code").val(data.product_code);
                $("#item_name").val(data.item_name);
                $("#purchase_price").val(data.item_purchase_rate);
                $("#undelivered_quantity").val(data.quantity);
                $("#value").val(data.item_purchase_rate * data.quantity);
                $("#saleable_stock").val(item_total_purchase);
                $("#current_stock").val(current_stock);
                $("#bill_id").val(data.bill_id);
                $("#item_id").val(data.id);
                $("#date").val(data.entry_date);

            });
        }
        $("#received_quantity").on('input',function() {

            var undeliver_quantity      =  parseInt($("#undelivered_quantity").val()) ?  parseInt($("#undelivered_quantity").val()) : 0;
            var receive_quantity        =  parseInt($("#received_quantity").val());

            if(undeliver_quantity < receive_quantity){
                $("#current_undelivered_quantity").val(undeliver_quantity);
            }else{
                var current_deiliverd_qty   =  undeliver_quantity - receive_quantity;
                $("#current_undelivered_quantity").val(current_deiliverd_qty);
            }

        });


    </script>
    <script>
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_receive_undelivered').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });
    </script>

    <script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>

@endsection
