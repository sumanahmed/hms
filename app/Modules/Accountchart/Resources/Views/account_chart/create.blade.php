@extends('layouts.main')

@section('title', 'Chart Of Accounts')

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
                                <h2 class="heading_b"><span class="uk-text-truncate">Create New Account</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            <div class="uk-margin-top">
                                {!! Form::open(['url' => route('account_chart_store'), 'method' => 'POST']) !!}

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="parent_account_type_id" class="uk-vertical-align-middle">Nature Type <span style="color: red">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="parent_account_type_id" name="parent_account_type_id" class="form-control">
                                                <option value="">Select type</option>
                                                @foreach($parent_account_types as $parent_account_type)
                                                    <option value="{{ $parent_account_type->id }}">{{ $parent_account_type->account_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->first('parent_account_type_id'))
                                                <div class="uk-text-danger uk-margin-top">Nature Group is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="account_type_id" class="uk-vertical-align-middle">Group<span style="color: red">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="account_type_id" name="account_type_id" class="form-control">
                                                <option value="">Select type</option>
                                                @foreach($account_types as $account_type)
                                                    <option value="{{ $account_type->id }}">{{ $account_type->account_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->first('account_type_id'))
                                                <div class="uk-text-danger uk-margin-top">Group is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="gl_account_type_id" class="uk-vertical-align-middle">GL<span style="color: red">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="gl_account_type_id" name="gl_account_type_id" class="form-control">
                                                <option value="">Select type</option>
                                                @foreach($account_gl as $account)
                                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->first('gl_account_type_id'))
                                                <div class="uk-text-danger uk-margin-top">Account GL is required.</div>
                                            @endif
                                        </div>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="visaType">
                                                <a data-toggle="uk-modal" data-uk-modal="{target:'#addGL'}" id="gl-modal" class="glModal" type="submit" class="sm-btn sm-btn-primary">+ Create GL</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="pgl_account_type_id" class="uk-vertical-align-middle">PGL<span style="color: red">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="pgl_account_type_id" name="pgl_account_type_id" class="form-control">
                                                <option value="">Select type</option>
                                                @foreach($account_pgl as $account)
                                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->first('pgl_account_type_id'))
                                                <div class="uk-text-danger uk-margin-top">Account PGL is required.</div>
                                            @endif
                                        </div>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="visaType">
                                                <a data-toggle="uk-modal" data-uk-modal="{target:'#addPGL'}" id="pgl-modal" class="pglModal" type="submit" class="sm-btn sm-btn-primary">+ Create PGL</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="account_name">Account Name <span style="color: red">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="account_name">Account Name</label>
                                            <input class="md-input" type="text" id="account_name" value="{{old('account_name')}}" name="account_name" />
                                            @if($errors->first('account_name'))
                                                <div class="uk-text-danger">Account name is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="account_code">Account Code</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <input class="md-input" value="{{old('account_code')}}" type="text" id="account_code" name="account_code" readonly/>
                                            @if($errors->first('account_code'))
                                                <div class="uk-text-danger">Account code is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <h4 class="full_width_in_card heading_c">
                                        If this account is associated with contact, then choose; otherwise keep it empty
                                    </h4>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="associated_with" class="uk-vertical-align-middle">Associated with</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="account_id" name="contact_id" class="form-control">
                                                <option selected disabled>Select type</option>
                                                @foreach($associate_accounts as $associate_account)
                                                    <option value="{{ $associate_account->id }}">{{ $associate_account->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="description">Description</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea class="md-input" value="{{old('description')}}" name="description" id="description" cols="30" rows="4" placeholder="Write description here..."></textarea>
                                            @if($errors->first('description'))
                                                <div class="uk-text-danger">Description is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-1-1 uk-float-right">
                                            <button type="submit" class="md-btn md-btn-primary" >Submit</button>
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
    <div class="uk-modal" id="addGL" role="dialog">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Add GL</h3>
            </div>

            <div class="uk-modal-body">
                <div class="md-card-content">
                    <div class="uk-overflow-container">

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label for="contact_category_id" class="uk-vertical-align-middle">Nature Group<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="parentAccountType"></p>
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label for="gl_modal_account_type_id" class="uk-vertical-align-middle">Group<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="accountType"></p>
                                <input type="hidden" class="accountTypeId" value="" />
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label class="uk-vertical-align-middle" for="gl_modal_account_name">GL Account Name<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label for="gl_modal_account_name">GL Account Name</label>
                                <input class="md-input" type="text" id="gl_modal_account_name" name="gl_modal_account_name" value=" " required/>
                                @if($errors->has('gl_modal_account_name'))
                                    <div class="uk-text-danger uk-margin-top">{{ $errors->first('gl_modal_account_name') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Cancel</button>
                <button id="submitGLBtn" type="submit" class="md-btn md-btn-flat md-btn-flat-primary submitbtn uk-modal-close">Confirm</button>
            </div>

        </div>
    </div>

    <div class="uk-modal" id="addPGL" role="dialog">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Add PGL</h3>
            </div>

            <div class="uk-modal-body">
                <div class="md-card-content">
                    <div class="uk-overflow-container">

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label for="contact_category_id" class="uk-vertical-align-middle">Nature Group<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="parentAccountType"></p>
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label for="gl_modal_account_type_id" class="uk-vertical-align-middle">Group<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="accountType"></p>
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label for="contact_category_id" class="uk-vertical-align-middle">GL<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="glAccountType"></p>
                                <input type="hidden" class="glAccountId" value="" />
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2 uk-vertical-align">
                                <label class="uk-vertical-align-middle" for="pgl_account_name">Account Name<span style="color: red;" class="asterisc">*</span></label>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label for="pgl_account_name">Account Name</label>
                                <input class="md-input" type="text" id="pgl_account_name" name="pgl_account_name" value=" " required/>
                                @if($errors->has('pgl_account_name'))
                                    <div class="uk-text-danger uk-margin-top">{{ $errors->first('pgl_account_name') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Cancel</button>
                <button id="submitPGLBtn" type="submit" class="md-btn md-btn-flat md-btn-flat-primary submitbtn uk-modal-close">Confirm</button>
            </div>

        </div>
    </div>
<!-- Modal End -->
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_account_chart_of_accounts').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });
    </script>

    <script>
        $(document).ready(function () {

            //Searchable all dropdown
                $("#parent_account_type_id").select2();
                $("#account_type_id").select2();
                $("#gl_account_type_id").select2();
                $("#pgl_account_type_id").select2();
                $("#account_id").select2();
            //Searchable all dropdown End


            $('.glModal').click(function () {
                $('.parentAccountType').text( $("#parent_account_type_id option:selected").html() );
                $('.accountType').text( $("#account_type_id option:selected").html() );
                $('.accountTypeId').text( $("#account_type_id option:selected").val() );
            });

            $('.pglModal').click(function () {
                $('.parentAccountType').text( $("#parent_account_type_id option:selected").html() );
                $('.accountType').text( $("#account_type_id option:selected").html() );
                $('.glAccountType').text( $("#gl_account_type_id option:selected").html() );
                $('.glAccountId').val( $("#gl_account_type_id option:selected").val() );
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#gl-modal").click(function(){
                $("#addGL").show();
            });

            $("#pgl-modal").click(function(){
                $("#addPGL").show();
            });
        });
    </script>

    <script>
        //add GL
        $('#submitGLBtn').click(function() {

            var account_type_id      = $('.accountTypeId').val();
            var account_name         = $("#gl_modal_account_name").val();

            $.ajax({
                type:   'post',
                url:    '/account-chart/add-gl',
                data:   { account_type_id: account_type_id, account_name: account_name },

                success: function (data) {
                    $('#gl_account_type_id').append($('<option>', {
                        value: data.id,
                        text: data.account_name,
                        'selected': 'selected'
                    }));

                    $('#addGL').hide();
                }
            });
        });

        //add PGL
        $('#submitPGLBtn').click(function() {

        var account_type_id         = $('.glAccountId').val();
        var account_name            = $("#pgl_account_name").val();

        $.ajax({

            type:   'post',
            url:    '/account-chart/add-pgl',
            data:   { account_type_id: account_type_id, account_name: account_name },

            success: function (data) {
                $('#pgl_account_type_id').append($('<option>', {
                    value: data.id,
                    text: data.account_name,
                    'selected': 'selected'
                }));

                $('#addPGL').hide();
            }

        });

    });
    </script>

    <script>
        $('#account_name').click(function () {
            var parentAccountType = $("#parent_account_type_id option:selected").val();
            var accountType = $("#account_type_id option:selected").val();
            var glAccountType = $("#gl_account_type_id option:selected").val();
            var pglAccountType = $("#pgl_account_type_id option:selected").val();

            $('#account_code').val(parentAccountType+accountType+glAccountType+pglAccountType);
        });
    </script>
@endsection