@extends('layouts.main')

@section('title', 'Special Offer')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Special Offer Detail</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            <div class="uk-overflow-container uk-margin-bottom">
                                <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                <table class="uk-table" cellspacing="0" width="100%" id="data_table" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Company</th>
                                            <th>Offer Validity</th>
                                            <th>SKU</th>
                                            <th>Qty</th>
                                            <th>Free SKU</th>
                                            <th>Qty</th>
                                            <th>From</th>
                                            <th>Till</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Company</th>
                                            <th>Offer Validity</th>
                                            <th>SKU</th>
                                            <th>Qty</th>
                                            <th>Free SKU</th>
                                            <th>Qty</th>
                                            <th>From</th>
                                            <th>Till</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach($offers as $offer)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $offer->display_name }}</td>
                                                <td>{{ $offer->from_date." - ".$offer->to_date }}</td>
                                                <td>{{ $offer->product_code}}</td>
                                                <td>{{ $offer->sku_qty }}</td>
                                                <td>{{ $offer->product_code }}</td>
                                                <td>{{ $offer->free_sku_qty }}</td>
                                                <td>{{ $offer->from_date }}</td>
                                                <td>{{ $offer->to_date }}</td>
                                                <td>{{ $offer->status == 0 ? 'Claim Incomplete' : 'Claim Complete' }} </td>
                                                <td>
                                                    <a href="{{ route('special_offer_save_claim',['id' => $offer->id]) }}" target="_blank"><i data-uk-tooltip="{pos:'top'}" class=" material-icons">history</i></a>
                                                    <a href="{{ route('special_offer_edit',['id' => $offer->id]) }}"><i data-uk-tooltip="{pos:'top'}" title="Edit" class="md-icon material-icons">&#xE254;</i></a>
                                                    <a class="delete_btn"><i data-uk-tooltip="{pos:'top'}" title="Delete" class="md-icon material-icons">&#xE872;</i></a>
                                                    <input class="offer_id" type="hidden" value="{{ $offer->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Add branch plus sign -->
                            <div class="md-fab-wrapper branch-create">
                                <a id="add_branch_button" href="{{ route('special_offer_create') }}" class="md-fab md-fab-accent branch-create">
                                    <i class="material-icons">&#xE145;</i>
                                </a>
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
        $('.delete_btn').click(function () {
            var id = $(this).next('.offer_id').val();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                window.location.href = "/special-offer/delete/"+id;
            })
        })
    </script>

    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_special_offer').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        })
    </script>
@endsection