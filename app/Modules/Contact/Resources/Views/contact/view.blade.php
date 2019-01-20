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
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>@lang('trans.contact')</span></a>
                    <div class="uk-dropdown">
                        <ul class="uk-nav uk-nav-dropdown">
                            @if($category_id == 1)
                                <li><a href="{{ route('contact_create',['id'=>1]) }}">@lang('trans.create_contact')</a></li>
                            @endif
                            @if($category_id == 2)
                                <li><a href="{{ route('contact_create',['id'=>2]) }}">@lang('trans.create_contact')</a></li>
                            @endif
                            @if($category_id == 3)
                                <li><a href="{{ route('contact_create',['id'=>3]) }}">@lang('trans.create_contact')</a></li>
                            @endif
                            <li><a href="{{ route('contact',['id'=>$category_id]) }}">@lang('trans.all_contact')</a></li>
                        </ul>
                    </div>
                </li>

                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="material-icons">&#xE02E;</i><span>@lang('trans.category')</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href="{{ route('category') }}">@lang('trans.all_category')</a></li>
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
                            @if($category_id == 1)
                                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                                     <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                             @if($contact->image)
                                                <img alt="user avatar" src="{{ asset($contact->image) }}">
                                            @else
                                                <img alt="user avatar" src="{{url('admin/assets/img/avatars/user.png')}}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b"><span class="uk-text-truncate">Display Name : <span style="color: yellow">{{ $contact->display_name }}</span> </span></h2>
                                    </div>
                                </div>

                                <div class="user_content">
                                    <div class="uk-margin-top">

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Company ID</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->serial  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="email_address">Propietor</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->propietor }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="email_address">Outlet</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->outlet }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="email_address">Address</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->address }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="email_address">Road</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <div class="uk-width-medium-2-5">
                                                   Road..
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="email_address">Mobile</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->mobile }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Note</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->note  }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if($category_id == 2)
                                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            @if($contact->image)
                                                <img alt="user avatar" src="{{ asset($contact->image) }}">
                                            @else
                                                <img alt="user avatar" src="{{url('admin/assets/img/avatars/user.png')}}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b"><span class="uk-text-truncate">Display Name : <span style="color: yellow">{{ $contact->display_name }}</span> </span></h2>
                                    </div>
                                </div>

                                <div class="user_content">
                                    <div class="uk-margin-top">

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Company ID</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->serial  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Office Address</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->office_address  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Office Phone</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->office_phone  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">RSM Mobile</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->rsm_mobile  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">TSM Mobile</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->tsm_mobile  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">SR Mobile</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->sr_mobile  }}
                                            </div>
                                        </div>

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label for="category_id" class="uk-vertical-align-middle">Note</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">
                                                {{ $contact->note  }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if($category_id == 3)
                                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            @if($contact->image)
                                                <img alt="user avatar" src="{{ asset($contact->image) }}">
                                            @else
                                                <img alt="user avatar" src="{{url('admin/assets/img/avatars/user.png')}}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b"><span class="uk-text-truncate">Display Name : <span style="color: yellow">{{ $contact->display_name }}</span> </span></h2>
                                    </div>
                                </div>

                                <div class="user_content">
                                        <div class="uk-margin-top">

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Employee ID</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->serial  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Designation</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_designation  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Address</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_address  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Phone</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_phone  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">NID</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_nid  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Reference</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_reference  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Mobile</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->employee_mobile  }}
                                                </div>
                                            </div>

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-5 uk-vertical-align">
                                                    <label for="category_id" class="uk-vertical-align-middle">Note</label>
                                                </div>
                                                <div class="uk-width-medium-2-5">
                                                    {{ $contact->note  }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_contact').addClass('act_item');
    </script>
@endsection