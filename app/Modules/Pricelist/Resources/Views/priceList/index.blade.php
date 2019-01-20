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
            <form action="" class="uk-form-stacked" id="user_edit_form">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                </div>
                                <div class="user_heading_content">
                                    <h2 class="heading_b"><span class="uk-text-truncate">@lang('inventory_price_list')</span></h2>
                                </div>
                            </div>
                            <div class="user_content">
                                <div class="uk-overflow-container uk-margin-bottom">
                                    <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                    <table class="uk-table" cellspacing="0" width="100%" id="data_table" >
                                        <thead>
                                        <tr>
                                            <th>@lang('trans.serial')</th>
                                            <th>@lang('trans.item_name')</th>
                                            <th>@lang('trans.contact_name')</th>
                                            <th>@lang('trans.sale_rate')</th>
                                            <th>@lang('trans.purchase_rate')</th>
                                            <th>@lang('trans.created_at')</th>
                                            <th class="uk-text-center">@lang('trans.action')</th>
                                        </tr>
                                        </thead>

                                        <tfoot>
                                        <tr>
                                            <th>@lang('trans.serial')</th>
                                            <th>@lang('trans.item_name')</th>
                                            <th>@lang('trans.contact_name')</th>
                                            <th>@lang('trans.sale_rate')</th>
                                            <th>@lang('trans.purchase_rate')</th>
                                            <th>@lang('trans.created_at')</th>
                                            <th class="uk-text-center">@lang('trans.action')</th>
                                        </tr>
                                        </tfoot>

                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($pricelist as $all)
                                            <tr>
                                                <td>
                                                    @if(Session::get('locale') == 'bn')
                                                        {{$helper->bn2enNumber( $i++ )}}
                                                    @else
                                                        {{ $i++ }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Session::get('locale') == 'bn')
                                                        {{ $all->item->item_name }}
                                                    @else
                                                        {{ $all->item->item_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Session::get('locale') == 'bn')
                                                        {{ $all->contact->display_name }}
                                                    @else
                                                        {{ $all->contact->display_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Session::get('locale') == 'bn')
                                                        {{$helper->bn2enNumber( $all->sales_rate )}}
                                                    @else
                                                        {{ $all->sales_rate }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Session::get('locale') == 'bn')
                                                        {{$helper->bn2enNumber( $all->purchase_rate )}}
                                                    @else
                                                        {{ $all->purchase_rate }}
                                                    @endif
                                                </td>
                                                <td>{{ $all->created_at }}</td>
                                                <td class="uk-text-center">
                                                    
                                                    <a href="{{ route('price_list_edit' , $all->id) }}"><i data-uk-tooltip="{pos:'top'}" title="@lang('trans.edit')" class="md-icon material-icons">&#xE254;</i></a>
                                                    <a class="delete_btn"><i data-uk-tooltip="{pos:'top'}" title="@lang('trans.delete')" class="md-icon material-icons">&#xE872;</i></a>
                                                    <input class="inventory_id" type="hidden" value="{{ route('price_list_delete',$all->id) }}">

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Add branch plus sign -->

                                <div class="md-fab-wrapper branch-create">
                                    <a id="add_branch_button" href="{{ route('price_list_create') }}" class="md-fab md-fab-accent branch-create">
                                        <i class="material-icons">&#xE145;</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('.delete_btn').click(function () {
            var url = $(this).next('.inventory_id').val();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                window.location.href = url;
            })
        })
    </script>

    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_inventory_price_list').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })
    </script>
@endsection
