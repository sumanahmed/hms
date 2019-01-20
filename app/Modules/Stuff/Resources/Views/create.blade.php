@extends('layouts.main')

@section('title', 'Stuff')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')
    <div class="uk-grid">
        <div class="uk-width-large-10-10">
            {!! Form::open(['url' => route('stuff_store'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-10-10 uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Create New Stuff</span></h2>
                            </div>
                        </div>


                        <div class="user_content">
                            <div class="uk-margin-top">

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="type">Type<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select id="type" name="type" required data-md-selectize aria-required="true">
                                            <option selected disabled="">Select</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Manager</option>
                                            <option value="3">Accountant</option>
                                            <option value="4">Pathlogist</option>
                                            <option value="5">IT</option>
                                            <option value="6">Receiptionist</option>
                                            <option value="7">Security Guard</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="error">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="name">Name<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="income_date">Name</label>
                                        <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required>
                                        @if ($errors->has('name'))
                                            <span class="error">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="mobile">Mobile<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="income_date">Mobile</label>
                                        <input class="md-input" type="number" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                                        @if ($errors->has('mobile'))
                                            <span class="error">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="age">Age</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="age">Age</label>
                                        <input class="md-input" type="number" id="age" name="age">
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="gender">Gender<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <span>
                                        <input type="radio" name="gender" id="val_radio_male" value="1" data-md-icheck />
                                            <label for="val_radio_male" class="inline-label">Male</label>
                                        </span>
                                        <span class="icheck-inline">
                                            <input type="radio" name="gender" value="2"id="val_radio_female" data-md-icheck />
                                            <label for="val_radio_female" class="inline-label">Female</label>
                                        </span>
                                        @if ($errors->has('gender'))
                                            <span class="error">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="nid">NID<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="nid">NID</label>
                                        <input class="md-input" type="text" id="nid" name="nid"  value="{{ old('nid') }}" required>
                                        @if ($errors->has('nid'))
                                            <span class="error">
                                                <strong>{{ $errors->first('nid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="degree">Degree<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="degree">Degree</label>
                                        <input class="md-input" type="text" id="degree" name="degree" value="{{ old('degree') }}">
                                        @if ($errors->has('degree'))
                                            <span class="error">
                                                <strong>{{ $errors->first('degree') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="joining_date">Joining Date<span class="req">*</span></label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="income_date">Select date</label>
                                        <input class="md-input" type="text" id="joining_date" name="joining_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD.MM.YYYY'}" required>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="image">File</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input type="file" name="image" class="md-input">
                                    </div>
                                </div>

                                <div class="uk-grid uk-ma" data-uk-grid-margin>
                                    <div class="uk-width-1-1 uk-float-left">
                                        <button type="submit" class="md-btn md-btn-primary" >Submit</button>
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
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
@section('script')
    <script>
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_stuff').addClass('act_item');
    </script>
@endsection