@extends('layouts.main')

@section('title', 'Chart Of Accounts')

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
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>All Account GL</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{ route('account_gl') }}" target="_blank">Account GL</a></li>
                        </ul>
                    </div>
                </li>

                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>All Account PGL</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{ route('account_pgl') }}" target="_blank">Account PGL</a></li>
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
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Update Account</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            <div class="uk-margin-top">
                                {!! Form::open(['url' => route('account_chart_update', ['id' => $account->id]), 'method' => 'POST']) !!}

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label for="parent_account_type_id" class="uk-vertical-align-middle">Nature Type <span style="color: red">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select id="parent_account_type_id" name="parent_account_type_id" class="form-control">
                                            <option value="">Select type</option>
                                            @foreach($parent_account_types as $parent_account_type)
                                                <option value="{{ $parent_account_type->id }}" @if($parent_account_type->id == $account->parent_account_type_id) selected @endif>{{ $parent_account_type->account_name }}</option>
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
                                                <option value="{{ $account_type->id }}" @if($account_type->id == $account->account_type_id) selected @endif>{{ $account_type->account_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('account_type_id'))
                                            <div class="uk-text-danger uk-margin-top">Group is required.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label for="account_type_id" class="uk-vertical-align-middle">GL<span style="color: red">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select id="gl_account_type_id" name="gl_account_type_id" class="form-control">
                                            <option value="">Select type</option>
                                            @foreach($account_gl as $account_val)
                                                <option value="{{ $account_val->id }}" @if($account_val->id == $account->account_gl_id) selected @endif>{{ $account_val->account_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('gl_account_type_id'))
                                            <div class="uk-text-danger uk-margin-top">Account GL is required.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label for="pgl_account_type_id" class="uk-vertical-align-middle">PGL<span style="color: red">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select id="pgl_account_type_id" name="pgl_account_type_id" class="form-control">
                                            <option value="">Select type</option>
                                            @foreach($account_pgl as $account_val)
                                                <option value="{{ $account_val->id }}" @if($account_val->id == $account->account_pgl_id) selected @endif >{{ $account_val->account_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('pgl_account_type_id'))
                                            <div class="uk-text-danger uk-margin-top">Account PGL is required.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="account_name">Account Name <span style="color: red">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="account_name">Account Name</label>
                                        <input class="md-input" type="text" id="account_name" value="{{ $account->account_name }}" name="account_name" />
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
                                        <input class="md-input" type="text" id="account_code" name="account_code" value="{{ $account->account_code }}" readonly/>
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
                                            <option value="0">Select type</option>
                                            @foreach($associate_accounts as $associate_account)
                                                <option value="{{ $associate_account->id }}" @if($associate_account->id == $account->contact_id) selected @endif>{{ $associate_account->display_name }}</option>
                                            @endforeach
                                            <input type="hidden" name="contact_account_id" value="{{ $contact_account_id['account_id'] }}" />
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="description">Description</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <textarea class="md-input" name="description" id="description" cols="30" rows="4" placeholder="Write description here...">{{ $account->description }}</textarea>
                                        @if($errors->first('description'))
                                            <div class="uk-text-danger">Description is required.</div>
                                        @endif
                                    </div>
                                </div>
                                <br>
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
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_account_chart_of_accounts').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });
    </script>
@endsection