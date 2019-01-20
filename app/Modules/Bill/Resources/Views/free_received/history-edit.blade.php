@extends('layouts.main')

@section('title', 'Free Received History')

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
                                <h2 class="heading_b"><span class="uk-text-truncate">Free Received History</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            {!! Form::open(['url' => route('free_received_history_update',['id'=>$bill_free_received_entry->id]), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}

                            <div class="uk-margin-top">

                                <input type="hidden" name="bill_free_entry_id" value="{{ $bill_free_received_entry->bill_free_entry_id }}">
                                <input type="hidden" name="bill_id" value="{{ $bill_free_received_entry->bill_id }}">
                                <input type="hidden" name="product_id" value="{{ $bill_free_received_entry->product_id }}">

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="date">Date<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="date">Select date</label>
                                        <input class="md-input" type="text" id="date" name="date" value="{{ $bill_free_received_entry->date }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                    </div>
                                    @if($errors->has('date'))
                                        <div class="uk-text-danger uk-margin-top">{{ $errors->first('date') }}</div>
                                    @endif
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="date">Purchase Invoice<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" value="{{ "PINV-".str_pad($bill_free_received_entry->bill_number, 6, '0', STR_PAD_LEFT)  }}" readonly>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="date">Total Receivable<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" name="received_quantity" id="" value="{{ $bill_free_received_entry->receivable_quantity +  $bill_free_received_entry->received_quantity }}" readonly>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="date">Total Received<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" name="received_quantity" id="received_quantity" value="{{ $bill_free_received_entry->received_quantity }}">
                                    </div>
                                </div>

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
@endsection

@section('scripts')
    <script>
        function changeQuantity(i) {
            var total_qty      = $("#total_qty_"+i).text();
            var received_qty     = $("#received_qty_"+i).val();

            if(received_qty > total_qty){
                $("#received_qty_"+i).val(total_qty);
            }

        }

    </script>

    <script>
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_free_received').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });
    </script>

    <script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>

@endsection
