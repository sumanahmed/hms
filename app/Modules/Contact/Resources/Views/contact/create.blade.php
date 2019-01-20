@extends('layouts.main')

@section('title', 'Contact')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('angular')
    <script src="{{url('app/contact/contact/contact.controller.js')}}"></script>
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
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile"
         xmlns:color="http://www.w3.org/1999/xhtml">
        <div class="uk-width-large-10-10" ng-controller="ContactController">
            {!! Form::open(['url' => route('contact_store',['id'=>$category_id] ), 'method' => 'post', 'class' => 'uk-form-stacked', 'id' => 'user_edit_form', 'files' => 'true']) !!}

            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Create @if($category_id == 1) Outlet @elseif($category_id == 2) Company @else Employee @endif</span></h2>
                            </div>
                        </div>
                        <div class="user_content">

                            <div class="uk-margin-top">

                                @if($category_id == 1)

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="display_name">Display Name <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="display_name">Display Name  </label>
                                            <input class="md-input" type="text" id="display_name" name="display_name" />
                                            @if($errors->has('display_name'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('display_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="serial">Customer ID<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <input class="md-input" type="text" id="serial" name="serial" value="{{ $outlet_id }}" readonly/>
                                            @if($errors->has('serial'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('serial') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="propietor">Propietor<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="propietor">Propietor</label>
                                            <input class="md-input" type="text" id="propietor" name="propietor" />
                                            @if($errors->has('propietor'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('propietor') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="outlet">Outlet <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="outlet">Outlet</label>
                                            <input class="md-input" type="text" id="outlet" name="outlet" />
                                            @if($errors->has('outlet'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('outlet') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="address">Address <span style="color: red;" class="asterisc">*</span></label>
                                            <label class="uk-vertical-align-middle" for="address">Address <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea class="md-input" name="address" id="address" cols="30" rows="4"></textarea>
                                            @if($errors->has('outlet'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('outlet') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="company_id">Company<span style="color: red;" class="asterisc">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select name="company_id[]" id="selec_adv_1" multiple>
                                                @foreach($companys as $company)
                                                    <option value="{{ $company->id }}">{{ $company->display_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('company_id'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('company_id') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="road">Road <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select name="road_id" data-md-selectize>
                                                @foreach($roads as $road)
                                                    <option value="{{ $road->id }}">{{ $road->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('road'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('road') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="mobile">Mobile <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="mobile">Mobile</label>
                                            <input class="md-input" type="text" id="mobile" name="mobile" />
                                            @if($errors->has('mobile'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('mobile') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($category_id == 2)

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="display_name">Display name <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="display_name">Display name  </label>
                                            <input class="md-input" type="text" id="display_name" name="display_name" />
                                            @if($errors->has('display_name'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('display_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="serial">Company ID<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <input class="md-input" type="text" id="serial" name="serial" value="{{ $company_id }}" readonly/>
                                            @if($errors->has('serial'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('serial') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="address">Office Address <span style="color: red;" class="asterisc">*</span></label>
                                            <label class="uk-vertical-align-middle" for="office_address">Office Address <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea class="md-input" name="office_address" id="office_address" cols="30" rows="4"></textarea>
                                            @if($errors->has('office_address'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('office_address') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="office_phone">Office Phone <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="office_phone">Office Phone</label>
                                            <input class="md-input" type="text" id="office_phone" name="office_phone" />
                                            @if($errors->has('office_phone'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('office_phone') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="rsm_mobile">RSM Mobile <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="rsm_mobile">RSM Mobile</label>
                                            <input class="md-input" type="text" id="rsm_mobile" name="rsm_mobile" />
                                            @if($errors->has('rsm_mobile'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('rsm_mobile') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="tsm_mobile">TSM Mobile <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="tsm_mobile">TSM Mobile</label>
                                            <input class="md-input" type="text" id="tsm_mobile" name="tsm_mobile" />
                                            @if($errors->has('tsm_mobile'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('tsm_mobile') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="sr_mobile">SR Mobile <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="sr_mobile">SR Mobile</label>
                                            <input class="md-input" type="text" id="sr_mobile" name="sr_mobile" />
                                            @if($errors->has('sr_mobile'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('sr_mobile') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($category_id == 3)

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="serial">Employee ID<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <input class="md-input" type="text" id="serial" name="serial" value="{{ $employee_id }}" readonly/>
                                            @if($errors->has('serial'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('serial') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="display_name">Display Name <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="display_name">Display Name </label>
                                            <input class="md-input" type="text" id="display_name" name="display_name" />
                                            @if($errors->has('display_name'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('display_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="employee_designation">Designation <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="employee_designation">Designation </label>
                                            <input class="md-input" type="text" id="employee_designation" name="employee_designation" />
                                            @if($errors->has('employee_designation'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_designation') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label for="address">Office Address <span style="color: red;" class="asterisc">*</span></label>
                                            <label class="uk-vertical-align-middle" for="employee_address">Address <span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea class="md-input" name="employee_address" id="employee_address" cols="30" rows="4"></textarea>
                                            @if($errors->has('employee_address'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_address') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="employee_phone">Phone<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="employee_phone">Phone</label>
                                            <input class="md-input" type="text" id="employee_phone" name="employee_phone" />
                                            @if($errors->has('employee_phone'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_phone') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="employee_nid">NID<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="employee_nid">NID</label>
                                            <input class="md-input" type="text" id="employee_nid" name="employee_nid" />
                                            @if($errors->has('employee_nid'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_nid') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="employee_reference">Reference<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="employee_reference">Reference</label>
                                            <input class="md-input" type="text" id="employee_reference" name="employee_reference" />
                                            @if($errors->has('employee_reference'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_reference') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="employee_mobile">Mobile<span style="color: red;" class="asterisc">*</span> </label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="employee_mobile">Mobile</label>
                                            <input class="md-input" type="text" id="employee_mobile" name="employee_mobile" />
                                            @if($errors->has('employee_mobile'))
                                                <div class="uk-text-danger uk-margin-top">{{ $errors->first('employee_mobile') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="note">Note</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <textarea class="md-input" name="note" id="note" cols="30" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="image">Image</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <input class="md-input" type="file" id="image" name="image" />
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
@endsection