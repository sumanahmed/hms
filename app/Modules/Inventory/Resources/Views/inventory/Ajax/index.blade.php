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
    <?php $helper = new \App\Lib\Helpers ?>
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
                                    <h2 class="heading_b"><span class="uk-text-truncate">@lang('trans.inventory_item_list')</span></h2>
                                </div>
                                <div class="uk-width-medium-1-1" style="text-align: right; right: 10px; position: absolute; top:10px;">
                                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light md-bg-blue-grey-400 alldata" >@lang('trans.show_all')</a>
                                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light md-bg-deep-orange-400 finddata">@lang('trans.find')</a>
                                </div>
                            </div>
                            <div class="md-card findinventory" >
                                <br/>
                                <hr/>
                                <div class="uk-width-large-1-2 uk-width-medium-1-2" style="margin: 0 auto">
                                    <div class="uk-input-group" >
                                        <div  class="md-input-wrapper"><label>@lang('trans.item')</label><input id="search_text" type="text" class="md-input"><span class="md-input-bar "></span></div>

                                        <span  class="uk-input-group-addon"><a id="search_box" class="md-btn" href="#">@lang('trans.search')</a></span>
                                    </div>

                                </div>
                                <br/>
                            </div>
                            <div class="user_content">

                                <div class="uk-overflow-container uk-margin-bottom">
                                    <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                    <div id="spinner" class="spinner"></div>
                                    <table class="uk-table" cellspacing="0" width="100%" id="data_table_1" >
                                        <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Company Name</th>
                                            <th>Entry Date</th>
                                            <th>Purchase Price</th>
                                            <th>Sales Price</th>
                                            <th class="uk-text-center">Action</th>
                                        </tr>
                                        </thead>

                                        <tfoot>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Company Name</th>
                                            <th>Entry Date</th>
                                            <th>Purchase Price</th>
                                            <th>Sales Price</th>
                                            <th class="uk-text-center">Action</th>
                                        </tr>
                                        </tfoot>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- Add branch plus sign -->

                                <div class="md-fab-wrapper branch-create">
                                    <a id="add_branch_button" href="{{ route('inventory_create') }}" class="md-fab md-fab-accent branch-create">
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


    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_inventory_inventory').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })

        var all_inventory_list = "{{ route("inventory_api_all_inventory_list") }}";
        var all_inventory_find = "{{ route("inventory_api_seach_inventory_items_key") }}";
        var all_inventory_view = "{{ route('inventory_show',["id"=>'']) }}";
        var all_inventory_edit = "{{ route('inventory_edit',["id"=>'']) }}";
        var all_stock_history = "{{ route('stock_history',["id"=>'']) }}";
        var all_stock_history_create = "{{ route('stock_history_create',["id"=>'']) }}";
        var all_inventory_delete = "{{ route('inventory_delete',["id"=>'']) }}";
        var stock_report = "{{ $stock_report }}";
        var item_report = "{{ $item_report }}";
        $("#spinner").removeClass("spinner");
        $(".finddata").on("click",function () {
            $(".findinventory").show(1000);
        });
        $(".alldata").on("click",function () {
            $(".findinventory").hide(800);
            $("#spinner").addClass("spinner");
            $.get(all_inventory_list,function (datalist) {
                console.log(datalist);
                var data = [];

                $.each(datalist, function(k, v) {
                    data.push([++k, v.item_name, v.product_code, v.display_name, v.entry_date, v.item_sales_rate, v.item_purchase_rate, v.id] );
                });

                $('#data_table_1').DataTable({
                    "pageLength": 50,
                    destroy: true,
                    data:           data,
                    deferRender:    true,
                    "columnDefs": [
                        {
                            "targets": 7,
                            "render": function ( link, type, row )
                            {
                               
                                var inventory_url = '';
                                var stock_report_url = stock_report.replace('new_id',link)
                                var item_report_url = item_report.replace('new_id',link)
                                if(link.item_category_id == 1){
                                    inventory_url+="<a href="+all_stock_history+"/"+link+"><i data-uk-tooltip title='History' class='material-icons'>&#xE85C;</i></a>";
                                }
                                inventory_url+= "<a target='_blank' href="+stock_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Stock Report" class=" material-icons">&#xE8CB;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+item_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Item Report" class=" material-icons">&#xE6C4;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+all_inventory_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="View" class=" material-icons">&#xE8F4;</i>'+"</a>";
                                inventory_url+="<a target='_blank' href="+all_inventory_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Edit" class=" material-icons">&#xE254;</i>'+"</a>";
                                inventory_url+=  "<a onclick='removeItem(this);' class='delete_btn'><i data-uk-tooltip=\"{pos:'top'}\" title='Delete' class='material-icons'>&#xE872;</i></a>";
                                inventory_url+=  "<input class='inventory_id' type='hidden' value="+all_inventory_delete+'/'+link+">";
                                if(link.item_category_id == 1){
                                    inventory_url+= "<a href="+all_stock_history_create+"/"+link+"><i data-uk-tooltip=\"{pos:'top'}\" title='Add Stock' class='material-icons'>&#xE147;</i></a>";
                                }
                                return inventory_url;
                            }
                        }
                    ]
                });
                $("#spinner").removeClass("spinner");
            });
        });

        $("#search_text").on("input",function () {
            var data = $("#search_text").val();
            if (data.length < 3) {
                return false;
            }
            $("#spinner").addClass("spinner");
            $.get(all_inventory_find,{ name: data },function (datalist) {
                var data = [];
                $.each(datalist, function(k, v) {
                    data.push([++k,v.item_name, v.product_code, v.display_name, v.entry_date, v.item_sales_rate, v.item_purchase_rate, v.id] );
                });
                $('#data_table_1').DataTable({
                    "pageLength": 50,
                    destroy: true,
                    data:           data,
                    deferRender:    true,
                    "columnDefs": [
                        {
                            "targets": 7,
                            "render": function ( link, type, row )
                            {
                                var inventory_url = '';
                                var stock_report_url = stock_report.replace('new_id',link)
                                var item_report_url = item_report.replace('new_id',link)
                                if(link.item_category_id == 1){
                                    inventory_url+="<a href="+all_stock_history+"/"+link+"><i data-uk-tooltip title='History' class='material-icons'>&#xE85C;</i></a>";
                                }
                                inventory_url+= "<a target='_blank' href="+stock_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.stock_report')" class=" material-icons">&#xE8CB;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+item_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.item_report')" class=" material-icons">&#xE6C4;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+all_inventory_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.view')" class=" material-icons">&#xE8F4;</i>'+"</a>";
                                inventory_url+="<a target='_blank' href="+all_inventory_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.edit')" class=" material-icons">&#xE254;</i>'+"</a>";
                                inventory_url+=  "<a onclick='removeItem(this);' class='delete_btn'><i data-uk-tooltip=\"{pos:'top'}\" title='@lang('trans.delete')' class='material-icons'>&#xE872;</i></a>";
                                inventory_url+=  "<input class='inventory_id' type='hidden' value="+all_inventory_delete+'/'+link+">";
                                if(link.item_category_id == 1){
                                    inventory_url+= "<a href="+all_stock_history_create+"/"+link+"><i data-uk-tooltip=\"{pos:'top'}\" title='@lang('trans.add_stock')' class='material-icons'>&#xE147;</i></a>";
                                }
                                return inventory_url;
                            }
                        }
                    ]
                });
                $("#spinner").removeClass("spinner");
            });

        });
        $("#search_box").on("click",function () {
            var data = $("#search_text").val();
            if (data.length < 3) {
                return false;
            }
            $("#spinner").addClass("spinner");
            $.get(all_inventory_find,{ name: data },function (datalist) {
                var data = [];
                $.each(datalist, function(k, v) {
                    data.push([++k,v.item_name, v.product_code, v.display_name, v.entry_date, v.item_sales_rate, v.item_purchase_rate, v.id] );
                });
                $('#data_table_1').DataTable({
                    "pageLength": 50,
                    destroy: true,
                    data:           data,
                    deferRender:    true,
                    "columnDefs": [
                        {
                            "targets": 7,
                            "render": function ( link, type, row )
                            {
                                var inventory_url = '';
                                var stock_report_url = stock_report.replace('new_id',link)
                                var item_report_url = item_report.replace('new_id',link)
                                if(link.item_category_id == 1){
                                    inventory_url+="<a href="+all_stock_history+"/"+link+"><i data-uk-tooltip title='History' class='material-icons'>&#xE85C;</i></a>";
                                }
                                inventory_url+= "<a target='_blank' href="+stock_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.stock_report')" class=" material-icons">&#xE8CB;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+item_report_url+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.item_report')" class=" material-icons">&#xE6C4;</i>'+"</a>";
                                inventory_url+= "<a target='_blank' href="+all_inventory_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.view')" class=" material-icons">&#xE8F4;</i>'+"</a>";
                                inventory_url+="<a target='_blank' href="+all_inventory_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="@lang('trans.edit')" class=" material-icons">&#xE254;</i>'+"</a>";
                                inventory_url+=  "<a onclick='removeItem(this);' class='delete_btn'><i data-uk-tooltip=\"{pos:'top'}\" title='@lang('trans.delete')' class='material-icons'>&#xE872;</i></a>";
                                inventory_url+=  "<input class='inventory_id' type='hidden' value="+all_inventory_delete+'/'+link+">";
                                if(link.item_category_id == 1){
                                    inventory_url+= "<a href="+all_stock_history_create+"/"+link+"><i data-uk-tooltip=\"{pos:'top'}\" title='@lang('trans.add_stock')' class='material-icons'>&#xE147;</i></a>";
                                }
                                return inventory_url;
                            }
                        }
                    ]
                });
                $("#spinner").removeClass("spinner");
            });

        });

        function removeItem(row)
        {
            var url = $(row).next('.inventory_id').val();

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
        }
    </script>
@endsection
