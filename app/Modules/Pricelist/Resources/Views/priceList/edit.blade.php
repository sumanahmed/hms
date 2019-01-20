@extends('layouts.main')

@section('title', 'Price List')

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
                <a href="#"><i class="material-icons">&#xE02E;</i><span>@lang('trans.inventory')</span></a>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="{{route('inventory_create')}}">@lang('trans.create_inventory')</a></li>
                        <li><a href="{{route('inventory')}}">@lang('trans.all_inventory')</a></li>
                    </ul>
                </div>
            </li>

            <li data-uk-dropdown class="uk-hidden-small">
                <a href="#"><i class="material-icons">&#xE02E;</i><span>@lang('trans.category')</span></a>
                <div class="uk-dropdown uk-dropdown-scrollable">
                    <ul class="uk-nav uk-nav-dropdown">
                        {{--<li><a href="{{route('inventory_category_create')}}">Create Category</a></li>--}}
                        <li><a href="{{route('inventory_category')}}">@lang('trans.all_category')</a></li>
                    </ul>
                </div>
            </li>
            <li data-uk-dropdown class="uk-hidden-small">
                <a href="{{route('stock_create')}}"><i class="material-icons">&#xE02E;</i><span>@lang('trans.add_stock')</span></a>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('content')
    <?php $helper = new \App\Lib\Helpers ?>
    @if(Session::has('message'))
        <div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            {!! Form::open(['url' => route('price_list_update', ['id' => $price_list->id]), 'method' => 'post', 'class' => 'uk-form-stacked', 'id' => 'user_edit_form']) !!}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                </div>
                                <div class="user_heading_content">
                                    <h2 class="heading_b"><span class="uk-text-truncate">@lang('trans.edit_price_item')</span></h2>
                                </div>
                            </div>
                            <div class="user_content">
                                <div class="uk-margin-top">
                                    
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="item_category_id" class="uk-vertical-align-middle">@lang('trans.contact_name')<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="item_category_id" name="contact" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select with tooltip">
                                                <option value="">@lang('trans.select_contact')</option>
                                                @foreach($contact as $all)
                                                    @if($all->id == $price_list->contact_id)
                                                        @if(Session::get('locale') == 'bn')
                                                            <option value="{{ $all->id }}" selected>{{ $all->display_name }}</option>
                                                        @else
                                                            <option value="{{ $all->id }}" selected>{{ $all->display_name }}</option>
                                                        @endif
                                                    @else
                                                        @if(Session::get('locale') == 'bn')
                                                            <option value="{{ $all->id }}">{{ $all->display_name }}</option>
                                                        @else
                                                            <option value="{{ $all->id }}">{{ $all->display_name }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if($errors->first('contact'))
                                                <div class="uk-text-danger uk-margin-top">Contact is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="item_category_id" class="uk-vertical-align-middle">@lang('trans.item_name')<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="item_category_id" name="item" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select with tooltip">
                                                <option value="">Select Item</option>
                                                @foreach($item as $all)
                                                    @if($all->id == $price_list->item_id)
                                                        @if(Session::get('locale') == 'bn')
                                                            <option value="{{ $all->id }}" selected>{{ $all->item_name }}</option>
                                                        @else
                                                            <option value="{{ $all->id }}" selected>{{ $all->item_name }}</option>
                                                        @endif
                                                    @else
                                                        @if(Session::get('locale') == 'bn')
                                                            <option value="{{ $all->id }}">{{ $all->item_name }}</option>
                                                        @else
                                                            <option value="{{ $all->id }}">{{ $all->item_name }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if($errors->first('item'))
                                                <div class="uk-text-danger uk-margin-top">Item is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_name">@lang('trans.sale_rate')</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_name">@lang('trans.sale_rate')</label>
                                            <input class="md-input" type="text" id="item_name" name="sales_rate" value="@if(Session::get('locale') == 'bn') {{ $helper->bn2enNumber($price_list->sales_rate) }} @else {{ $price_list->sales_rate }} @endif
                                                    "/>
                                            
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_name">@lang('trans.purchase_rate')</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_name">@lang('trans.purchase_rate')</label>
                                            <input class="md-input" type="text" id="purchase_rate" name="purchase_rate" value="@if(Session::get('locale') == 'bn') {{ $helper->bn2enNumber($price_list->purchase_rate) }} @else {{  $price_list->purchase_rate }} @endif"/>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="item_about">@lang('trans.comment')(En)</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="item_about">@lang('trans.comment_eng')</label>
                                            <textarea class="md-input" name="comment" id="comment" cols="30" rows="4">{{ $price_list->comment }}</textarea>
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
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_inventory_price_list').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })
    </script>
@endsection