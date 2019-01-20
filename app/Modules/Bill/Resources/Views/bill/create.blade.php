@extends('layouts.main')

@section('title', 'Purchase Invoice')

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
                            {!! Form::open(['url' => route('purchase_invoice_store'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                            <div class="uk-margin-top">

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="invoice_date">Date<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="bill_date">Select date</label>
                                        <input class="md-input" type="text" id="bill_date" name="bill_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                    </div>
                                    @if($errors->has('bill_date'))
                                        <div class="uk-text-danger uk-margin-top">{{ $errors->first('bill_date') }}</div>
                                    @endif
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="bill_number">Invoice No<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" id="bill_number" name="bill_number" value="{{ "PINV-".$bill_number }}" readonly required/>
                                    </div>
                                    @if($errors->has('bill_number'))
                                        <div class="uk-text-danger uk-margin-top">{{ $errors->first('bill_number') }}</div>
                                    @endif
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="company_invoice">Company Invoice<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="company_invoice">Company Invoice</label>
                                        <input class="md-input" type="text" id="company_invoice" name="company_invoice" value="" required=""/>
                                        @if($errors->has('company_invoice'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('company_invoice') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="company_id">Company Name<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select class="form-control" title="Select Company" id="company_id" name="company_id" required>
                                            <option value="">Select Company</option>
                                            @foreach($company as $value)
                                                <option value="{{ $value->id }}">{{ $value->serial." ".$value->display_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('company_id'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('company_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top uk-margin-large-bottom" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-1">
                                        <table class="uk-table">
                                            <thead>
                                                <tr>
                                                    <th class="uk-text-nowrap">Product Name</th>
                                                    <th class="uk-text-nowrap">Rate/PCS</th>
                                                    <th class="uk-text-nowrap">Ct. Size</th>
                                                    <th class="uk-text-nowrap">Pur. Qty</th>
                                                    <th class="uk-text-nowrap">Undel. Qty</th>
                                                    <th class="uk-text-nowrap">Deli. Qty</th>
                                                    <th class="uk-text-nowrap">value</th>
                                                </tr>
                                            </thead>
                                            <tbody class="getMultipleRow">

                                               <tr class="tr0">
                                                    <td>
                                                        <select name="item_id[]"  onchange="selectProduct(0)" class="getProductList md-input" id="item_id0">

                                                        </select>
                                                        <div class="get_cartoon_size" id="get_cartoon_size0"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input" name="rate[]" oninput="calculateActualAmount(0)" id="rate0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input" name="curtoon_size[]" oninput="calculateActualAmount(0)" id="curtoon_size0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input" name="quantity[]" oninput="calculateActualAmount(0, 3)" id="quantity0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input" name="undelivered_quantity[]" oninput="calculateActualAmount(0, 0)" id="undelivered_quantity0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input" name="delivered_quantity[]" oninput="calculateActualAmount(0, 1)" id="delivered_quantity0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="md-input row_total" name="amount[]" oninput="calculateActualAmount(0, 2)" id="row_total0" value="">
                                                    </td>
                                                    <td class="uk-text-right uk-text-middle">
                                                        <span class="uk-input-group-addon">
                                                            <a class="add_row"><i class="material-icons md-24">&#xE146;</i></a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3 uk-margin-medium-top"></div>
                                    <div class="uk-width-medium-2-3">
                                        <table class="uk-table">
                                            <tbody>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>Total BDT</td>
                                                    <td> <input type="text" class="md-input" name="total_amount" id="totalBdt" readonly></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>Unload Payment</td>
                                                    <td> <input type="text" class="md-input" name="unload_payment" id="unloadPayment"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>Grand Total</td>
                                                    <td> <input type="text" class="md-input" name="grand_total" id="grandTotal" readonly></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>Paid Amount</td>
                                                    <td> <input type="text" class="md-input" name="paid_amount" id="paidAmount"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td>Due Amount</td>
                                                    <td> <input type="text" class="md-input" name="due_amount" id="dueAmount" readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="due_date">Due Date<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="due_date">Select date</label>
                                        <input class="md-input" type="text" id="due_date" name="due_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                    </div>
                                    @if($errors->has('due_date'))
                                        <div class="uk-text-danger uk-margin-top">{{ $errors->first('due_date') }}</div>
                                    @endif
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="image">Image</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="file" id="image" name="image">
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="note">Note</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="note">Customer Note</label>
                                        <textarea class="md-input" name="note" id="note"></textarea>
                                    </div>
                                </div>

                                <div class="uk-grid" >
                                    <div class="uk-width-1-2">
                                        <div style=" padding:10px;height: 40px; color: white; background-color: #2D2D2D ">
                                            Create Account Entries
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2" style="padding: 10px; height: 40px; position:relative;background: #2D2D2D ">
                                        <div id="inv" style="position: absolute; right: 10px; height: 40px; ">
                                            <input {{ old('check_journal_entry')?"checked" : '' }} type="checkbox" name="check_journal_entry" id="check_journal_entry" style=" margin-top: -1px; height: 25px; width: 20px;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid" style="display: none;" id="journal_entry_details">
                                    <div class="uk-width-1-1" >
                                        <div class="uk-grid uk-margin-large-bottom" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <table class="uk-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="uk-text-nowrap">Account</th>
                                                            <th class="uk-text-nowrap">Debit</th>
                                                            <th class="uk-text-nowrap">Credit</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="getRow">

                                                        <tr class="journal_tr_0">
                                                            <td>
                                                                <select name="account_id[]"  onchange="selectAccount(0)" class="getJournalAccountList form-control" id="account_id_0">
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}" @if( $account->id == 1) selected @endif >{{ $account->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input debit" name="debit[]" oninput="calculateJournal(0)" id="debit_0" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input credit" name="credit[]" oninput="calculateJournal(0)" id="credit_0" value="">
                                                            </td>
                                                            <td class="uk-text-right uk-text-middle">
                                                                <span class="uk-input-group-addon">
                                                                    <a class="add_journal_row"><i class="material-icons md-24">&#xE146;</i></a>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr class="journal_tr_1">
                                                            <td>
                                                                <select name="account_id[]"  onchange="selectAccount(1)" class="getJournalAccountList form-control" id="account_id_1">
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input debit" name="debit[]" oninput="calculateJournal(1)" id="debit_1" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input credit" name="credit[]" oninput="calculateJournal(1)" id="credit_1" value="">
                                                            </td>
                                                            <td class="uk-text-right uk-text-middle">
                                                                <span class="uk-input-group-addon">
                                                                    <a onclick="deleteJournalEntryRow(1)" class="add_journal_row"><i class="material-icons md-24">delete</i></a>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr class="journal_tr_2">
                                                            <td>
                                                                <select name="account_id[]"  onchange="selectAccount(2)" class="getJournalAccountList form-control" id="account_id_2">
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}" @if( $account->id == 2) selected @endif >{{ $account->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input debit" name="debit[]" oninput="calculateJournal(2)" id="debit_2" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input credit" name="credit[]" oninput="calculateJournal(2)" id="credit_2" value="">
                                                            </td>
                                                            <td class="uk-text-right uk-text-middle">
                                                                <span class="uk-input-group-addon">
                                                                    <a onclick="deleteJournalEntryRow(2)" class="add_journal_row"><i class="material-icons md-24">delete</i></a>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr class="journal_tr_3">
                                                            <td>
                                                                <select name="account_id[]"  onchange="selectAccount(3)" class="getJournalAccountList form-control" id="account_id_3">
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input debit" name="debit[]" oninput="calculateJournal(3)" id="debit_3" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="md-input credit" name="credit[]" oninput="calculateJournal(3)" id="credit_3" value="">
                                                            </td>
                                                            <td class="uk-text-right uk-text-middle">
                                                                <span class="uk-input-group-addon">
                                                                    <a onclick="deleteJournalEntryRow(3)" class="add_journal_row"><i class="material-icons md-24">delete</i></a>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td> <input type="text" class="md-input" id="totalDebit" value="" readonly> </td>
                                                        <td> <input type="text" class="md-input" id="totalCredit" value="" readonly> </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid" >
                                    <div class="uk-width-1-2">
                                        <div style=" padding:10px;height: 40px; color: white; background-color: #2D2D2D ">
                                            Create Free Entries
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2" style="padding: 10px; height: 40px; position:relative;background: #2D2D2D ">
                                        <div id="inv" style="position: absolute; right: 10px; height: 40px; ">
                                            <input {{ old('check_free_entry')?"checked" : '' }} type="checkbox" name="check_free_entry" id="check_free_entry" style=" margin-top: -1px; height: 25px; width: 20px;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid" style="display: none;" id="free_entry_details">
                                    <div class="uk-width-1-1" >
                                        <div class="uk-grid uk-margin-large-bottom" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <table class="uk-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="uk-text-nowrap">Free Product</th>
                                                            <th class="uk-text-nowrap">Total Quantity</th>
                                                            <th class="uk-text-nowrap">Received Quantity</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="getFreeEntryRow">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin id="submit" style="display: none;">
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
@endsection

@section('scripts')
    <script>
        var ajax_data = [];

        $(document).ready(function() {

            //Get product by select company
                $('#company_id').change(function() {
                    var company_id = $("#company_id option:selected").val();
                    if(company_id){
                        $.get('/purchase-invoice/ajax-product/'+ company_id, function(data){

                            ajax_data = data;

                            $('.getProductList').empty();
                            $('.getProductList').append('<option value="0">Select</option>');
                            for(var i =0; i< data.products.length; i++){
                                $('.getProductList').append( ' <option value="'+data.products[i].id+'"  purchase-rate="'+data.products[i].item_purchase_rate+'"  product-curtoon-size="'+data.products[i].curtoon_size+'">'+data.products[i].item_name+'</option> ' );
                            }
                        });
                    }
                });

            //Get product by click + sign depend on selected company
                $(".getProductList").select2();
                $("#company_id").select2();
                $("#account_id_0").select2();
                $("#account_id_1").select2();
                $("#account_id_2").select2();
                $("#account_id_3").select2();

                var rowindex =  0;

                $('.add_row').click(function() {

                    var company_id = $("#company_id option:selected").val();

                    if(company_id){
                        $.get('/purchase-invoice/ajax-product/'+ company_id, function(data){

                            rowindex++;
                            $('.getMultipleRow').append( ' ' +
                                '<tr class="tr'+rowindex+'">\n' +
                                '     <td>\n' +
                                '           <select name="item_id[]" onchange="selectProduct('+rowindex+')" class="getProductList md-input" id="item_id'+rowindex+'">\n'+
                                '              <option value="">Select</option>\n' +
                                '          </select>\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '          <input type="text" class="md-input" name="rate[]" value="0" oninput="calculateActualAmount('+rowindex+')" id="rate'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '          <input type="text" class="md-input" name="curtoon_size[]" value="0" oninput="calculateActualAmount('+rowindex+')" id="curtoon_size'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '         <input type="text" class="md-input" name="quantity[]" value="0" oninput="calculateActualAmount('+rowindex+', '+3+')" id="quantity'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '           <input type="text" class="md-input" name="undelivered_quantity[]" value="0" oninput="calculateActualAmount('+rowindex+', '+0+')" id="undelivered_quantity'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '           <input type="text" class="md-input" name="delivered_quantity[]" value="0" oninput="calculateActualAmount('+rowindex+', '+1+')" id="delivered_quantity'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td>\n' +
                                '         <input type="text" class="md-input row_total" name="amount[]" value="0" oninput="calculateActualAmount('+rowindex+', '+2+')" id="row_total'+rowindex+'" >\n' +
                                '     </td>\n' +
                                '     <td class="uk-text-right uk-text-middle remove_field">\n' +
                                '         <a href="#!" onclick="deleteRow('+rowindex+')" class="material-icons md-24">delete</a>\n' +
                                '     </td>\n' +
                                ' </tr>');

                            for(var tmp = 0; tmp < data.products.length; tmp++){
                                $('#item_id'+rowindex).append(
                                    '<option value="'+data.products[tmp].id+'" purchase-rate="'+data.products[tmp].item_purchase_rate+'" product-curtoon-size="'+data.products[tmp].curtoon_size+'">'+data.products[tmp].item_name+'</option> \n'
                                );
                            }

                            $("#item_id"+rowindex).select2();

                        });
                    }
                });
        });

        //Product rate and curtoon size
            function selectProduct(index) {
                $("#rate"+index).html('');
                $("#curtoon_size"+index).html('');
                $("#quantity"+index).html('');
                $("#undelivered_quantity"+index).html('');
                $("#delivered_quantity"+index).html('');
                $("#row_total"+index).html('');

                var product_id                  = $("#item_id" + index + " option:selected").val();
                var product_rate                = parseFloat($("#item_id" + index + " option:selected").attr("purchase-rate"));

                //when product change
                    $("#rate" + index).val(product_rate);
                    $("#curtoon_size"+index).val('');
                    $("#quantity"+index).val('');
                    $("#undelivered_quantity"+index).val('');
                    $("#delivered_quantity"+index).val('');
                    $("#row_total"+index).val(0);

                //when product select value == 0, empty all field value
                    if( product_id == 0 ){
                        $("#rate"+index).val(0);
                        $("#curtoon_size"+index).val(0);
                        $("#quantity"+index).val(0);
                        $("#undelivered_quantity"+index).val(0);
                        $("#delivered_quantity"+index).val(0);
                        $("#row_total"+index).val(0);
                        $("#totalBdt").val(0);
                        $("#grandTotal").val(0);
                        $("#dueAmount").val(0);
                    }
            }

        //for apending first row end
            function calculateActualAmount(i, arg)
            {
                var rate                    = parseFloat($("#rate" + i).val());
                var item_id                 = parseInt($("#item_id" + i + " option:selected").val());
                var product_curtoon_size    = parseInt($("#item_id" + i + " option:selected").attr("product-curtoon-size"));
                var curtoon_size            = parseInt($("#curtoon_size"+i).val());
                var quantity                = parseInt($("#quantity"+i).val()) > 0 ? parseInt($("#quantity"+i).val()) : 0;
                var purchase_quantity       = 0;
                var row_total               = parseFloat($("#row_total" + i).val()) > 0 ? parseFloat($("#row_total" + i).val()) : 0;
                var totalBdt                = 0;
                var paid_amount             = 0;
                var due_amount              = 0;
                var unload_payment          = 0;
                var grand_total             = 0;

                //Purchase Quantity
                    if(arg != 3) {
                        purchase_quantity  = product_curtoon_size  *  curtoon_size;
                        quantity           = purchase_quantity;

                        if (purchase_quantity > 0) {
                            $("#quantity" + i).val(purchase_quantity);
                        } else {
                            $("#quantity" + i).val(0);
                        }
                    }
                    else{

                        var new_purchase_quantity   = parseInt($("#quantity"+i).val()) > 0  ? parseInt($("#quantity"+i).val()) : 0;
                        $("#quantity" + i).val(new_purchase_quantity);

                        quantity                    = new_purchase_quantity;

                        var new_curtoon_size        = parseInt(new_purchase_quantity / product_curtoon_size);
                        $("#curtoon_size"+i).val(new_curtoon_size);

                    }

                    if(arg == 0){

                        var undelivered_quantity    = parseInt($("#undelivered_quantity"+i).val()) > 0  ? parseInt($("#undelivered_quantity"+i).val()) : 0;

                        if(undelivered_quantity <= quantity){

                            $("#delivered_quantity" + i).val(quantity - undelivered_quantity);

                            var delivered_quantity      = parseInt($("#delivered_quantity"+i).val()) > 0  ? parseInt($("#delivered_quantity"+i).val()) : 0;

                        }else{

                            $("#undelivered_quantity" + i).val(quantity);
                            $("#delivered_quantity" + i).val(0);

                        }

                    }
                    else if(arg == 1){

                        var delivered_quantity      = parseInt($("#delivered_quantity"+i).val()) > 0  ? parseInt($("#delivered_quantity"+i).val()) : 0;

                        if(delivered_quantity <= quantity){

                            $("#undelivered_quantity" + i).val(quantity - delivered_quantity);

                            var undelivered_quantity    = parseInt($("#undelivered_quantity"+i).val()) > 0  ? parseInt($("#undelivered_quantity"+i).val()) : 0;

                        }else{

                            $("#undelivered_quantity" + i).val(0);
                            $("#delivered_quantity" + i).val(quantity);

                        }

                    }
                    else{

                        var undelivered_quantity    = parseInt($("#undelivered_quantity"+i).val()) > 0  ? parseInt($("#undelivered_quantity"+i).val()) : 0;
                        var delivered_quantity      = parseInt($("#delivered_quantity"+i).val()) > 0  ? parseInt($("#delivered_quantity"+i).val()) : 0;

                        delivered_quantity          = quantity - undelivered_quantity;
                        undelivered_quantity        = quantity - delivered_quantity;

                        $("#undelivered_quantity" + i).val(undelivered_quantity);
                        $("#delivered_quantity" + i).val(delivered_quantity);
                    }

                    if(arg == 2){
                        var rowTotal  = parseInt($("#row_total"+i).val()) > 0  ? parseInt($("#row_total"+i).val()) : 0;
                        var rate      = rowTotal / quantity;
                        $("#rate"+i).val(rate);
                    }

                //Calculate Row total amount
                    row_total = rate * quantity;

                    if(row_total > 0){
                        $("#row_total" + i).val(row_total);
                    }
                    else{
                        $("#row_total" + i).val(0);
                    }

                //Calculate Total Amount
                    $(".row_total").each(function(){
                        totalBdt   += parseFloat($(this).val());
                    });
                    $("#totalBdt").val(totalBdt);

                //Calculate grand total
                    unload_payment  = $("#unloadPayment").val();
                    grand_total     = $("#totalBdt").val() - unload_payment;
                    $("#grandTotal").val(grand_total);
                    $("#dueAmount").val(grand_total);

                //Calculate Due Amount
                    paid_amount = $("#paidAmount").val();

                    if(paid_amount > 0) {
                        due_amount = $("#grandTotal").val() - paid_amount;
                        $("#dueAmount").val(due_amount);
                    }
                    else{
                        $("#dueAmount").val(grand_total);
                    }

            }

        //Calculate Grand Total
            $("#unloadPayment").on('input',function()
            {
                var unload_pay_amount    = parseFloat($("#unloadPayment").val());
                var total_bdt            = parseFloat($("#totalBdt").val());

                if(unload_pay_amount > total_bdt || unload_pay_amount < 0) {

                    $("#unloadPayment").val(total_bdt);
                    var unload_payment_amount = 0;
                    $("#grandTotal").val(unload_payment_amount);

                }else{

                    var grand_total = $("#totalBdt").val() - $(this).val();
                    $("#grandTotal").val(grand_total);

                }
            });

        //Due Amount
            $("#paidAmount").on('input',function()
            {
                    var paid_amount = parseFloat($("#paidAmount").val());
                    var grand_total = parseFloat($("#grandTotal").val());

                    if(paid_amount > grand_total || paid_amount < 0){

                        $("#paidAmount").val(grand_total);
                        var due_amount  =   0;
                        $("#dueAmount").val(due_amount);

                    }else{

                        var due_amount  =   $("#grandTotal").val() - $(this).val();
                        $("#dueAmount").val(due_amount);

                    }
            });

        //Remove Row
            function deleteRow(rowindex) {
                var totalBdt = $("#totalBdt").val() - $("#row_total"+rowindex).val();
                $("#totalBdt").val(totalBdt);
                $(".tr"+rowindex).remove();
            }

    </script>

    <script>

        $("#check_journal_entry").on("click",function () {
            $("#journal_entry_details").toggle(800);

            var due_amount          = parseFloat($("#dueAmount").val());
            var unload_payment      = parseFloat($("#unloadPayment").val());
            var paid_payment        = parseFloat($("#paidAmount").val());
            var product_total       = parseFloat($("#totalBdt").val());

            var total_row           = parseInt($(".getJournalAccountList").size());
            var totalDebit          = 0;
            var totalCredit         = 0;
            var grand_total         = parseFloat($("#grandTotal").val());
            var total_item          = parseInt($(".getProductList").size());

            //show Due Amount in credit
                $("#credit_0").val(due_amount);

            //show Unload Payment Amount in credit
                if(unload_payment > 0 && ajax_data.unload_account !== null){

                   $(".journal_tr_1").show();
                   $("#credit_1").val(unload_payment);

                   var ajax_data_unload_id = ajax_data.unload_account['id'];

                    $("#account_id_1").children('[value="'+ajax_data_unload_id+'"]').attr('selected', true);

                }else{
                    $(".journal_tr_1").hide();
                }
            //show paid Amount in credit
                $("#credit_2").val(paid_payment);

            //show Total BDT Amount in credit
                if( product_total  > 0 && ajax_data.purchase_account !== null ){
                   $(".journal_tr_3").show();
                   $("#debit_3").val(product_total);

                    var ajax_data_purchase_account_id = ajax_data.purchase_account['id'];

                    $("#account_id_3").children('[value="'+ajax_data_purchase_account_id+'"]').attr('selected', true);
                }else{
                    $(".journal_tr_3").hide();
                }

            /*Total Debit*/
                $(".debit").each(function(){
                    if(parseFloat($(this).val()) > 0){
                        totalDebit += parseFloat($(this).val());
                    }
                });

                if(totalDebit > 0){
                    $("#totalDebit").val(totalDebit);
                }
            /*Total Debit End*/

            /*Total Credit*/
                $(".credit").each(function(){
                    if(parseFloat($(this).val()) > 0){
                        totalCredit += parseFloat($(this).val());
                    }
                });

                if(totalCredit > 0){
                    $("#totalCredit").val(totalCredit);
                }
            /*Total Credit End*/

            /*Show Submit Button*/
                var total_debit = $("#totalDebit").val();
                var total_credit = $("#totalCredit").val();

                if(total_debit == total_credit && total_item > 0 && grand_total > 0 && due_amount >= 0){
                    $("#submit").show();
                }else{
                    $("#submit").hide();
                }
            /*Show Submit Button End*/

        });

        $(document).ready(function () {
            var rowindex =  3;
            $('.add_journal_row').click(function() {

                rowindex++;

                $('.getRow').append(
                    '<tr class="journal_tr_'+ rowindex +'">\n' +
                    '    <td>\n' +
                    '      <select name="account_id[]" class="getJournalAccountList form-control" id="account_id_'+ rowindex +'">\n' +
                    '          @foreach($accounts as $account)\n' +
                    '             <option value="{{ $account->id }}">{{ $account->account_name }}</option>\n' +
                    '          @endforeach\n' +
                    '      </select>\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '      <input type="text" class="md-input debit" name="debit[]" oninput="calculateJournal('+ rowindex +')" id="debit_'+ rowindex +'" value="">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '      <input type="text" class="md-input credit" name="credit[]" oninput="calculateJournal('+ rowindex +')" id="credit_'+ rowindex +'" value="">\n' +
                    '    </td>\n' +
                    '    <td class="uk-text-right uk-text-middle">\n' +
                    '      <span class="uk-input-group-addon">\n' +
                    '        <a onclick="deleteJournalEntryRow('+ rowindex +')" ><i class="material-icons md-24">delete</i></a>\n' +
                    '      </span>\n' +
                    '    </td>\n' +
                    '</tr>');
            });
            $("#account_id_"+rowindex).select2();

        });

        function calculateJournal(i){
            var grand_total         = parseFloat($("#grandTotal").val());
            var due_amount          = parseFloat($("#dueAmount").val());
            var total_item          = parseInt($(".getProductList").size());
            var totalDebit          = 0;
            var totalCredit         = 0;

            /*Total Debit*/
                $(".debit").each(function(){
                    if(parseFloat($(this).val()) > 0){
                        totalDebit += parseFloat($(this).val());
                    }
                });

                if(totalDebit > 0){
                    $("#totalDebit").val(totalDebit);
                }
            /*Total Debit End*/

            /*Total Credit*/
                $(".credit").each(function(){
                    if(parseFloat($(this).val()) > 0){
                        totalCredit += parseFloat($(this).val());
                    }
                });

                if(totalCredit > 0){
                $("#totalCredit").val(totalCredit);
            }
            /*Total Credit End*/

            /*Show Submit Button*/
                var total_debit = $("#totalDebit").val();
                var total_credit = $("#totalCredit").val();

                if(total_debit == total_credit && total_item > 0 && grand_total > 0 && due_amount >= 0){
                    $("#submit").show();
                }else{
                    $("#submit").hide();
                }
            /*Show Submit Button End*/
        }

        //Remove Journal Entry Row
            function deleteJournalEntryRow(rowindex) {
                $(".journal_tr_"+rowindex).remove();
            }
    </script>

    <script>
        $("#check_free_entry").on("click",function () {

            $("#free_entry_details").toggle(800);

            var total_row = $(".getProductList").size();
            var rowindex = 0;

            for (var i = 0; i < total_row; i++) {
                var bill_date   = $("#bill_date").val();
                var item_id     = $("#item_id" + i).val();
                var quantity    = $("#quantity" + i).val();

                if (quantity > 0 && item_id > 0) {
                    $.get('/purchase-invoice/ajax-free-item/' + item_id + '/' + quantity + '/' + bill_date, function (data) {
                        $('.getFreeEntryRow').append(
                            '<tr class="free_entry_tr_' + rowindex + '">\n' +
                            '    <td>\n' +
                            '       <select name="product_id[]"  class="getFreeEntryList form-control" id="product_id_' + rowindex + '">\n' +
                            '             <option value="' + data.free_sku_id + '">' + data.item_name + '</option>\n' +
                            '       </select>\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <input type="text" class="md-input" name="total_qty[]" oninput="calculateFreeEntry(' + rowindex + ')" id="total_qty_' + rowindex + '" value="' + data.total_qty + '">\n' +
                            '     <input type="hidden" name="bill_entry_index[]"  id="bill_entry_index_' + rowindex + '" value="'+rowindex+'">\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '     <input type="text" class="md-input" name="received_qty[]" oninput="calculateFreeEntry(' + rowindex + ')" id="received_qty_' + rowindex + '" value="0">\n' +
                            '     <input type="hidden" name="special_offer_id[]"  id="special_offer_id_' + rowindex + '" value="'+data.special_offer_id+'">\n' +
                            '   </td>\n' +
                            '   <td class="uk-text-right uk-text-middle">\n' +
                            '      <span class="uk-input-group-addon">\n' +
                                (rowindex == 0 ?
                                    '<a onclick="addNewRow()"> <i class="material-icons md-24">&#xE146;</i> </a>'
                                    :
                                    '<a onclick="deleteFreeEntryRow(' + rowindex + ')"><i class="material-icons md-24">delete</i></a>'
                                ) +
                            '      </span>\n' +
                            '   </td>\n' +
                            '  </tr>' +
                            '');
                        rowindex++;
                    });
                }
            }
        });


        var j = $(".getFreeEntryList").size() - 1;

        function addNewRow() {
            j++;
            $('.getFreeEntryRow').append(
                '<tr class="free_entry_tr_' + j + '">\n' +
                '    <td>\n' +
                '       <select name="product_id[]" class="getFreeEntryList form-control" id="product_id_' + j + '">\n' +
                '             <option selected disabled>Select</option>\n' +
                '          @foreach($products as $product)\n' +
                '             <option value="{{ $product->id }}")>{{ $product->item_name }}</option>\n' +
                '          @endforeach\n' +
                '       </select>\n' +
                '   </td>\n' +
                '   <td>\n' +
                '      <input type="text" class="md-input" name="total_qty[]" oninput="calculateFreeEntry(' + j + ')" id="total_qty_' + j + '" value="">\n' +
                '   </td>\n' +
                '   <td>\n' +
                '     <input type="text" class="md-input" name="received_qty[]" oninput="calculateFreeEntry(' + j + ')" id="received_qty_' + j + '" value="">\n' +
                '   </td>\n' +
                '   <td class="uk-text-right uk-text-middle">\n' +
                '      <span class="uk-input-group-addon">\n' +
                '          <a onclick="deleteFreeEntryRow(' + j + ')"><i class="material-icons md-24">delete</i></a>\n' +
                '      </span>\n' +
                '   </td>\n' +
                '  </tr>' +
            '');
        }


        function calculateFreeEntry(i) {
            var total_qty       = parseInt($("#total_qty_"+i).val()) ? parseInt($("#total_qty_"+i).val()) : 0;
            var received_qty    = parseInt($("#received_qty_"+i).val()) ? parseInt($("#received_qty_"+i).val()) : 0;

            if (received_qty > total_qty) {
                $("#received_qty_"+i).val(total_qty);
            }
        }

        //Remove Journal Entry Row
        function deleteFreeEntryRow(rowindex) {
            $(".free_entry_tr_" + rowindex).remove();
        }

    </script>

    <script>

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_purchase_invoice').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });

    </script>

    <script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>

@endsection
