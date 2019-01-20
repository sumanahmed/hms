@extends('layouts.main')

@section('title', 'Product')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('top_bar')
    <div id="top_bar">
        <div class="md-top-bar">
            <ul id="menu_top" class="uk-clearfix">
                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Inventory</span></a>
                    <div class="uk-dropdown">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{route('inventory_create')}}">Create Inventory</a></li>
                            <li><a href="{{route('inventory')}}">All Inventory</a></li>
                        </ul>
                    </div>
                </li>

                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Category</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            {{--<li><a href="{{route('inventory_category_create')}}">Create Category</a></li>--}}
                            <li><a href="{{route('inventory_category')}}">All Category</a></li>
                        </ul>
                    </div>
                </li>
                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Manage Sub Category</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{ route('inventory_sub_category') }}">Sub Category</a></li>
                        </ul>
                    </div>
                </li>
                <li class="uk-hidden-small">
                    <a href="{{route('stock_create')}}"><i class="material-icons">&#xE02E;</i><span>Add Stock</span></a>
                </li>
                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Search By Category</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{ route('inventory') }}">All Inventory</a></li>
                            @foreach($item_categories as $item_categories_data)
                                <li><a href="{{ route('inventory_search', ['id' => $item_categories_data->id]) }}">{{ $item_categories_data->item_category_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            {!! Form::open(['url' => route('inventory_store'), 'method' => 'post', 'enctype'=>'multipart/form-data', 'class' => 'uk-form-stacked', 'id' => 'user_edit_form']) !!}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                </div>
                                <div class="user_heading_content">
                                    <h2 class="heading_b"><span class="uk-text-truncate">@lang('trans.create_new_item')</span></h2>
                                </div>
                            </div>
                            <div class="user_content">
                                <div class="uk-margin-top">

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="entry_date">Entry Date</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="entry_date">Select date</label>
                                            <input class="md-input" type="text" id="entry_date" name="entry_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>

                                    <h3 class="full_width_in_card heading_c">
                                        Product Detail
                                    </h3>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="product_code">Product Code<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="product_code">Product Code</label>
                                            <input class="md-input" type="text" id="product_code" name="product_code" value="{{ $product_code }}" required readonly/>
                                            @if($errors->has('product_code'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('product_code') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="company_id" class="uk-vertical-align-middle">Company Name</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select class="form-control" id="company_id" name="company_id">
                                                @foreach($comapny as $value)
                                                    <option value="{{ $value->id }}">{{ $value->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_name">Product Name<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_name">Product Name</label>
                                            <input class="md-input" type="text" id="item_name" name="item_name" value="{{ old('item_name') }}" required/>
                                            @if($errors->has('item_name'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('item_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="curtoon_size">Curtoon Size<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="curtoon_size">Curtoon Size</label>
                                            <input class="md-input" type="text" id="curtoon_size" name="curtoon_size" value="{{ old('curtoon_size') }}" required/>
                                            @if($errors->has('curtoon_size'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('curtoon_size') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="unit_type">Unit Type<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="unit_type">Unit Type</label>
                                            <input class="md-input" type="text" id="unit_type" name="unit_type" value="{{ old('unit_type') }}" required/>
                                            @if($errors->has('unit_type'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('unit_type') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <h3 class="full_width_in_card heading_c">
                                        <span class="">
                                            <label for="sales_information" class="inline-label">Pricing Information</label>
                                        </span>
                                    </h3>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_sales_rate">Sales Price</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_sales_rate">Sales Price</label>
                                            <input class="md-input" type="number" id="item_sales_rate" name="item_sales_rate" value="{{old('item_sales_rate')}}" />
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_purchase_rate">Purchase Price</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_purchase_rate">Purchase Price</label>
                                            <input class="md-input" type="text" id="item_purchase_rate" name="item_purchase_rate" value="{{ old('item_purchase_rate') }}"/>
                                        </div>
                                    </div>

                                    <h3 class="full_width_in_card heading_c">
                                        Other Information
                                    </h3>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_about">Note</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea class="md-input" name="note" id="note" cols="30" rows="4">{{old('note')}}</textarea>
                                            @if($errors->first('note'))
                                                <div class="uk-text-danger uk-margin-top">Note is Required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="image">Image</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <input class="md-input" type="file" id="image" name="image" />
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-1-1 uk-float-right">
                                            <button type="submit" class="md-btn md-btn-primary" >@lang('trans.submit')</button>
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">@lang('trans.close')</button>
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

        function categoryChange(){

            var main_category = $('#item_category').val();

            $.get("{{ route('inventory_sub_category_show',['id'=>'']) }}/" + main_category, function(data){

                var list = '';

                list = '<option value = "0">' + "@lang('trans.select_sub_category')" + '</option>';

                $.each(data, function(i, data)
                {
                    list += '<option value = "' + data.id + '">' + data.item_sub_category_name + '</option>';
                });

                $("#item_sub_category").html(list);

            });

        }

        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_inventory_inventory').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })

        $(document).ready(function () {
            $("#company_id").select2();
        });
    </script>
@endsection