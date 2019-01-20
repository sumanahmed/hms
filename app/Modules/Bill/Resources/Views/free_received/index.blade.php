@extends('layouts.main')

@section('title', 'Free Received')

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
                                <h2 class="heading_b"><span class="uk-text-truncate">Free Received</span></h2>
                            </div>
                        </div>

                        <div class="user_content">
                            <div class="uk-overflow-container uk-margin-bottom">
                                <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                <table class="uk-table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Total Receivable</th>
                                        <th>Total Bill</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Total Receivable</th>
                                        <th>Total Bill</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody id="invoice_quantity">
                                        <?php $i=0; ?>
                                        @foreach($bill_free_entry as $all)
                                            <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $all->item['item_name'] }}</td>
                                            <td>{{ $all->total_receivable }}</td>
                                            <td>{{ $all->total_bill }}</td>
                                            <td>
                                                <a href="{{ route('free_received_history', $all->bill_free_receive_entry_id) }}"><i data-uk-tooltip="{pos:'top'}" title="History" class="material-icons">history</i></a>
                                                <a href="{{ route('free_received_create', $all->product_id) }}"><i data-uk-tooltip="{pos:'top'}" title="Create" class="material-icons">&#xE145;</i></a>
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

    </script>
@endsection
