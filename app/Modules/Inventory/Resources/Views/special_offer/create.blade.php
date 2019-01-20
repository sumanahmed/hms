@extends('layouts.main')

@section('title', 'Special Offer')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('angular')
    <script src="{{url('app/contact/contact/contact.controller.js')}}"></script>
@endsection


@section('content')
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile"
         xmlns:color="http://www.w3.org/1999/xhtml">
        <div class="uk-width-large-10-10" ng-controller="ContactController">
            {!! Form::open(['url' => route('special_offer_store'), 'method' => 'post', 'class' => 'uk-form-stacked', 'id' => 'user_edit_form', 'files' => 'true']) !!}

            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Create Special Offer</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            <div class="uk-margin-top">

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="from_date">From Date<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="from_date">Select date</label>
                                        <input class="md-input" type="text" id="from_date" name="from_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        @if($errors->has('from_date'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('from_date') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="to_date">To Date<span style="color: red;" class="asterisc">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="to_date">Select date</label>
                                        <input class="md-input" type="text" id="to_date" name="to_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        @if($errors->has('to_date'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('to_date') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="company_id">Company Name <span style="color: red;" class="asterisc">*</span> </label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select class="md-input" id="company_id" name="company_id" data-md-selectize >
                                            @foreach($company as $value)
                                                <option value="{{ $value->id }}">{{ $value->display_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('company_id'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('company_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="sku_id">SKU <span style="color: red;" class="asterisc">*</span> </label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select class="md-input" id="sku_id" name="sku_id" data-md-selectize >
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_code }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sku_id'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('sku_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="sku_qty">Quantity <span style="color: red;" class="asterisc">*</span> </label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" id="sku_qty" name="sku_qty" />
                                        @if($errors->has('sku_qty'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('sku_qty') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="free_sku_id">Free SKU <span style="color: red;" class="asterisc">*</span> </label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select class="md-input" id="free_sku_id" name="free_sku_id" data-md-selectize >
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_code }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('free_sku_id'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('free_sku_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="free_sku_qty">Quantity <span style="color: red;" class="asterisc">*</span> </label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="text" id="free_sku_qty" name="free_sku_qty" />
                                        @if($errors->has('free_sku_qty'))
                                            <div class="uk-text-danger uk-margin-top">{{ $errors->first('free_sku_qty') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-1-1 uk-float-right">
                                        <button type="submit" class="md-btn md-btn-primary" >Submit</button>
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_special_offer').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })
    </script>
@endsection