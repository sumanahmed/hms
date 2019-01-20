@extends('layouts.main')

@section('title', 'Contact')

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
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>Road</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a target="_blank" href="{{ route('road_index') }}">All Road</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<script>
    function contactRemove(row){
        var id = $(row).next('.category_id').val();
        var contact_category_id = $('.contact_category_id').val();
        console.log();
            swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            window.location.href = "/contact/remove/"+contact_category_id+"/"+id;
        })
    }
</script>
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
                                    <h2 class="heading_b"><span class="uk-text-truncate">@if($category_id == 1) Outlet @elseif($category_id == 2) Company @else Employee @endif List</span></h2>
                                </div>
                                <div class="uk-width-medium-1-1" style="text-align: right; right: 10px; position: absolute; top:10px;">
                                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light md-bg-blue-grey-400 alldata" >Show all</a>
                                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light md-bg-deep-orange-400 finddata">Find</a>
                                </div>
                        </div>
                        <div class="md-card findcontact" >
                            <br/>
                              <hr/>
                            <div class="uk-width-large-1-2 uk-width-medium-1-2" style="margin: 0 auto">
                                <div class="uk-input-group" >
                                    <div  class="md-input-wrapper"><label>Contact</label><input id="search_text" name="name" type="text" class="md-input"><span class="md-input-bar "></span></div>

                                    <span  class="uk-input-group-addon"><a id="search_box" class="md-btn" href="#">Search</a></span>
                                </div>

                            </div>
                            <br/>
                        </div>

                            <div class="user_content">

                                <div class="uk-overflow-container uk-margin-bottom">
                                    <div id="spinner" class="spinner"></div>
                                    <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>

                                    @if($category_id == 1)
                                        <table class="uk-table" cellspacing="0" width="100%" id="data_table_1" >
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Display Name</th>
                                                <th>Customer ID</th>
                                                <th>Proprietor</th>
                                                <th>Outlet</th>
                                                <th>Mobile</th>
                                                <th class="uk-text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Display Name</th>
                                                <th>Customer ID</th>
                                                <th><Proprietor></Proprietor></th>
                                                <th>Outlet</th>
                                                <th>Mobile</th>
                                                <th class="uk-text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                        <?php $i=1; ?>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    @endif

                                    @if($category_id == 2)
                                        <table class="uk-table" cellspacing="0" width="100%" id="data_table_1" >
                                            <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Display Name</th>
                                                <th>Company ID</th>
                                                <th>Office Address</th>
                                                <th>Office Phone</th>
                                                <th>SR Mobile</th>
                                                <th class="uk-text-center">Action</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Display Name</th>
                                                <th>Company ID</th>
                                                <th>Office Address</th>
                                                <th>Office Phone</th>
                                                <th>SR Mobile</th>
                                                <th class="uk-text-center">Action</th>
                                            </tr>
                                            </tfoot>
                                            <?php $i=1; ?>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    @endif

                                    @if($category_id == 3)
                                        <table class="uk-table" cellspacing="0" width="100%" id="data_table_1">
                                            <thead>
                                                <tr>
                                                    <th>Serial</th>
                                                    <th>Display Name</th>
                                                    <th>Employee ID</th>
                                                    <th>Designation</th>
                                                    <th>NID</th>
                                                    <th>Mobile</th>
                                                    <th class="uk-text-center">Action</th>
                                                </tr>
                                            </thead>

                                            <tfoot>
                                                <tr>
                                                    <th>Serial</th>
                                                    <th>Display Name</th>
                                                    <th>Employee ID</th>
                                                    <th>Designation</th>
                                                    <th>NID</th>
                                                    <th>Mobile</th>
                                                    <th class="uk-text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                            <?php $i=1; ?>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                                <!-- Add branch plus sign -->
                                @if($category_id == 1)
                                    <div class="md-fab-wrapper branch-create">
                                        <a id="add_branch_button" href="{{ route('contact_create',['id'=>1]) }}" class="md-fab md-fab-accent branch-create">
                                            <i class="material-icons">&#xE145;</i>
                                        </a>
                                    </div>
                                @endif
                                @if($category_id == 2)
                                    <div class="md-fab-wrapper branch-create">
                                        <a id="add_branch_button" href="{{ route('contact_create',['id'=>2]) }}" class="md-fab md-fab-accent branch-create">
                                            <i class="material-icons">&#xE145;</i>
                                        </a>
                                    </div>
                                @endif
                                @if($category_id == 3)
                                    <div class="md-fab-wrapper branch-create">
                                        <a id="add_branch_button" href="{{ route('contact_create',['id'=>3]) }}" class="md-fab md-fab-accent branch-create">
                                            <i class="material-icons">&#xE145;</i>
                                        </a>
                                    </div>
                                @endif

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
        $('.agent_delete_btn').click(function () {
            var id = $(this).next('.agent_id').val();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                window.location.href = "/contact/remove-agent/"+id;
            })
        })
    </script>

    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');

        @if($category_id == 1)
            $('#sidebar_contact_outlet').addClass('act_item');
        @endif
        @if($category_id == 2)
            $('#sidebar_contact_companies').addClass('act_item');
        @endif
        @if($category_id == 3)
            $('#sidebar_contact_employee').addClass('act_item');
        @endif

        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })
    </script>


<script>
    var all_contact_list = "{{ route("contact_api_get_all_contact_list",['id'=>$category_id]) }}";
    var all_contact_find_by_name = "{{ route("contact_api_get_all_contact_find_by_name",['id'=>$category_id]) }}";
    var all_contact_view = "{{ route('contact_view',["category_id"=>$category_id, 'id'=>'']) }}";
    var all_contact_edit = "{{ route('contact_edit',["category_id"=>$category_id, 'id'=>'']) }}";
    var contact_details = "{{ $contact_route }}";
    var contact_transaction = "{{ $contact_transaction }}";
    $("#spinner").removeClass("spinner");

    $(".finddata").on("click",function () {
        $(".findcontact").show(800);
    });

    $(".alldata").on("click",function () {

        $("#spinner").addClass("spinner");
        $(".findcontact").hide(800);

        $.get(all_contact_list,function (datalist) {
            var data = [];

            $.each(datalist, function(k, v) {
                if(v.contact_category_id == 1) {
                    data.push([++k, v.display_name, v.serial, v.propietor, v.outlet, v.mobile, v.id]);
                }
                if(v.contact_category_id == 2) {
                    data.push([++k, v.display_name, v.serial, v.office_address, v.office_phone, v.sr_mobile, v.id]);
                }
                if(v.contact_category_id == 3) {
                    data.push([++k, v.display_name, v.serial, v.employee_designation, v.employee_nid, v.employee_mobile, v.id]);
                }
            });

            $('#data_table_1').DataTable({
                "pageLength": 50,
                destroy: true,
                data:           data,
                deferRender:    true,
                "columnDefs": [
                    {
                        "targets": 6,
                        "render": function ( link, type, row ) {

                            var url = contact_transaction.replace('new_id',link)
                            var contact_url = "<a target='_blank' href="+all_contact_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="View" class="md-icon material-icons">&#xE8F4;</i>'+"</a>";
                            contact_url+="<a target='_blank' href="+all_contact_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Edit" class="md-icon material-icons">&#xE254;</i>'+"</a>";
                            contact_url+='<a onclick="contactRemove(this)" class="delete_btn"><i data-uk-tooltip="{pos:\'top\'}" title="Delete" class="md-icon material-icons">&#xE872;</i></a>';
                            contact_url+='<input class="category_id" type="hidden" value="'+link+'">';
                            return contact_url ;
                            // return link;
                        }
                    }

                ]
            });
            $("#spinner").removeClass("spinner");
        });
    });

    $("#search_text").on("input ",function () {
        var data = $("#search_text").val();
        if(data.length<3)
        {
            return false;
        }
        $("#spinner").addClass("spinner");
        //validation end
        $.get(all_contact_find_by_name,{ name: data },function (datalist) {
            var data = [];

            $.each(datalist, function(k, v) {
                if(v.contact_category_id == 1) {
                    data.push([++k, v.display_name, v.serial, v.propietor, v.outlet, v.mobile, v.id]);
                }
                if(v.contact_category_id == 2) {
                    data.push([++k, v.display_name, v.serial, v.office_address, v.office_phone, v.sr_mobile, v.id]);
                }
                if(v.contact_category_id == 3) {
                    data.push([++k, v.display_name, v.serial, v.employee_designation, v.employee_nid, v.employee_mobile, v.id]);
                }
            });

            $('#data_table_1').DataTable({
                "pageLength": 50,
                destroy: true,
                data:data,
                deferRender:    true,
                "columnDefs": [
                    {
                        "targets": 6,
                        "render": function ( link, type, row ) {
                            var url = contact_transaction.replace('new_id',link)
                            var contact_url = "<a target='_blank' href="+all_contact_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="View" class="md-icon material-icons">&#xE8F4;</i>'+"</a>";
                            contact_url+="<a target='_blank' href="+all_contact_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Edit" class="md-icon material-icons">&#xE254;</i>'+"</a>";
                            contact_url+='<a onclick="contactRemove(this)" class="delete_btn"><i data-uk-tooltip="{pos:\'top\'}" title="Delete" class="md-icon material-icons">&#xE872;</i></a>';
                            contact_url+='<input class="category_id" type="hidden" value="'+link+'">';
                            return contact_url ;
                            // return link;
                        }
                    }
                ]
            });
            $("#spinner").removeClass("spinner");
        });
        $("#spinner").removeClass("spinner");
    });
    $("#search_box").on("click",function () {
        var data = $("#search_text").val();
        if(data.length<1)
        {
            return false;
        }
        $("#spinner").addClass("spinner");
        //validation end
        $.get(all_contact_find_by_name,{ name: data },function (datalist) {
            var data = [];

            $.each(datalist, function(k, v) {
                if(v.contact_category_id == 1) {
                    data.push([++k, v.display_name, v.serial, v.propietor, v.outlet, v.mobile, v.id]);
                }
                if(v.contact_category_id == 2) {
                    data.push([++k, v.display_name, v.serial, v.office_address, v.office_phone, v.sr_mobile, v.id]);
                }
                if(v.contact_category_id == 3) {
                    data.push([++k, v.display_name, v.serial, v.employee_designation, v.employee_nid, v.employee_mobile, v.id]);
                }
            });

            $('#data_table_1').DataTable({
                "pageLength": 50,
                destroy: true,
                data:data,
                deferRender:    true,
                "columnDefs": [
                    {
                        "targets": 8,
                        "render": function ( link, type, row ) {
                            var url = contact_transaction.replace('new_id',link)
                            var contact_url = "<a target='_blank' href="+all_contact_view+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="View" class="md-icon material-icons">&#xE8F4;</i>'+"</a>";
                            contact_url+="<a target='_blank' href="+all_contact_edit+"/"+link+">"+'<i data-uk-tooltip="{pos:\'top\'}" title="Edit" class="md-icon material-icons">&#xE254;</i>'+"</a>";
                            contact_url+='<a onclick="contactRemove(this)" class="delete_btn"><i data-uk-tooltip="{pos:\'top\'}" title="Delete" class="md-icon material-icons">&#xE872;</i></a>';
                            contact_url+='<input class="category_id" type="hidden" value="'+link+'">';

                            return contact_url ;
                            // return link;
                        }
                    }
                ]
            });
            $("#spinner").removeClass("spinner");
        });
        $("#spinner").removeClass("spinner");
    });
    $('html').bind('keypress', function(e)
    {
        if(e.keyCode == 13)
        {
            return false;
        }
    });
</script>




@endsection