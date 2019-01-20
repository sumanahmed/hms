@extends('layouts.main')

@section('title', 'Free Received History')

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
                                <h2 class="heading_b"><span class="uk-text-truncate">Free Received History</span></h2>
                            </div>
                        </div>

                        <div class="user_content">
                            <div class="uk-overflow-container uk-margin-bottom">
                                <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                <table class="uk-table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Purchase Invoice</th>
                                        <th>Total Received</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Purchase Invoice</th>
                                        <th>Total Received</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody id="invoice_quantity">
                                    <?php $i=0; ?>
                                    @foreach($bill_free_received_entry as $all)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $all->date }}</td>
                                            <td>{{ "PINV-".str_pad($all->bill_number, 6, '0', STR_PAD_LEFT)  }}</td>
                                            <td>{{ $all->received_quantity }}</td>
                                            <td>
                                                <a href="{{ route('free_received_history_edit', $all->id) }}"><i data-uk-tooltip="{pos:'top'}" title="Edit" class="material-icons">&#xE254;</i></a>
                                                <a class="delete_btn"><i data-uk-tooltip="{pos:'top'}" title="Delete" class="material-icons">&#xE872;</i></a>
                                                <input type="hidden" class="bill_id" value="{{ $all->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_free_received').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });

        $('.delete_btn').click(function () {
            var id = $(this).next('.bill_id').val();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                window.location.href = "/purchase-invoice/delete/" + id;
            })
        })

    </script>
@endsection
