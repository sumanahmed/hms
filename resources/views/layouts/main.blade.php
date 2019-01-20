<!DOCTYPE html>
<!--[if lte IE 9]>
    <html class="lte-ie9" lang="en">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" ng-app="app">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">

    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta content="no" name="msapplication-tap-highlight">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <link href="{{ url('admin/assets/img/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png">
    <link href="'{{ url('admin/assets/img/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png">

    <title>@yield('title')</title>

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link href="{{ url('admin/bower_components/uikit/css/uikit.almost-flat.min.css') }}" rel="stylesheet">

    <!-- style switcher -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/style_switcher.min.css') }}" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/main.css') }}" media="all">

    <!-- themes -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/themes/themes_combined.min.css') }}" media="all">

    <!-- Select 2 Css -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/select2.css') }}" media="all">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/custom.css') }}" media="all">

    <!-- dropify -->
    <link rel="stylesheet" href="{{ url('admin/assets/skins/dropify/css/dropify.css') }}">

    <!-- kendo UI -->
    <link rel="stylesheet" href="{{url('admin/bower_components/kendo-ui/styles/kendo.common-material.min.css')}}"/>
    <link rel="stylesheet" href="{{url('admin/bower_components/kendo-ui/styles/kendo.material.min.css')}}" id="kendoCSS"/>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.css">

    <style>
        .uk-form-select{
            color:rgba(0, 0, 0, 0.8) !important;
        }
    </style>
    @yield('styles')
</head>

<body class="sidebar_main_open sidebar_main_swipe ">

@yield('header')

@yield('sidebar')

@yield('top_bar')

<div id="page_content">
    <div id="page_content_inner">
        @include('inc.alert')
        @yield('content')
    </div>
</div>

<!-- google web fonts -->
<script>
    // WebFontConfig = {
    //     google: {
    //         families: [
    //             'Source+Code+Pro:400,700:latin',
    //             'Roboto:400,300,500,700,400italic:latin'
    //         ]
    //     }
    // };
    // (function() {
    //     var wf = document.createElement('script');
    //     wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
    //         '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    //     wf.type = 'text/javascript';
    //     wf.async = 'true';
    //     var s = document.getElementsByTagName('script')[0];
    //     s.parentNode.insertBefore(wf, s);
    // })();
</script>



<!-- common functions -->

<script src="{{ url('admin/assets/js/common.min.js') }}"></script>
<!-- uikit functions -->
<script src="{{ url('admin/assets/js/uikit_custom.js') }}"></script>

<!-- altair core functions -->
<script src="{{ url('admin/assets/js/altair_admin_common.min.js') }}"></script>

<div id="style_switcher">
    <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
    <div class="uk-margin-medium-bottom">
        <h4 class="heading_c uk-margin-bottom">Colors</h4>
        <ul class="switcher_app_themes" id="theme_switcher">
            <li class="app_style_default active_theme" data-app-theme="">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_a" data-app-theme="app_theme_a">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_b" data-app-theme="app_theme_b">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_c" data-app-theme="app_theme_c">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_d" data-app-theme="app_theme_d">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_e" data-app-theme="app_theme_e">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_f" data-app-theme="app_theme_f">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_g" data-app-theme="app_theme_g">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_h" data-app-theme="app_theme_h">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_i" data-app-theme="app_theme_i">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_dark" data-app-theme="app_theme_dark">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
        </ul>
    </div>
    <div class="uk-visible-large uk-margin-medium-bottom">
        <h4 class="heading_c">Sidebar</h4>
        <p>
            <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
            <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
        </p>
        <p>
            <input type="checkbox" name="style_sidebar_slim" id="style_sidebar_slim" data-md-icheck />
            <label for="style_sidebar_slim" class="inline-label">Slim Sidebar</label>
        </p>
    </div>
    <div class="uk-visible-large uk-margin-medium-bottom">
        <h4 class="heading_c">Layout</h4>
        <p>
            <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
            <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
        </p>
    </div>
    <div class="uk-visible-large">
        <h4 class="heading_c">Main menu accordion</h4>
        <p>
            <input type="checkbox" name="accordion_mode_main_menu" id="accordion_mode_main_menu" data-md-icheck />
            <label for="accordion_mode_main_menu" class="inline-label">Accordion mode</label>
        </p>
    </div>
</div>

<script>
    $(function() {
        var $switcher = $('#style_switcher'),
            $switcher_toggle = $('#style_switcher_toggle'),
            $theme_switcher = $('#theme_switcher'),
            $mini_sidebar_toggle = $('#style_sidebar_mini'),
            $slim_sidebar_toggle = $('#style_sidebar_slim'),
            $boxed_layout_toggle = $('#style_layout_boxed'),
            $accordion_mode_toggle = $('#accordion_mode_main_menu'),
            $html = $('html'),
            $body = $('body');


        $switcher_toggle.click(function(e) {
            e.preventDefault();
            $switcher.toggleClass('switcher_active');
        });

        $theme_switcher.children('li').click(function(e) {
            e.preventDefault();
            var $this = $(this),
                this_theme = $this.attr('data-app-theme');

            $theme_switcher.children('li').removeClass('active_theme');
            $(this).addClass('active_theme');
            $html
                .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i app_theme_dark')
                .addClass(this_theme);

            if(this_theme == '') {
                localStorage.removeItem('altair_theme');
                $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
            } else {
                localStorage.setItem("altair_theme", this_theme);
                if(this_theme == 'app_theme_dark') {
                    $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.materialblack.min.css')
                } else {
                    $('#kendoCSS').attr('href','bower_components/kendo-ui/styles/kendo.material.min.css');
                }
            }

        });

        // hide style switcher
        $document.on('click keyup', function(e) {
            if( $switcher.hasClass('switcher_active') ) {
                if (
                    ( !$(e.target).closest($switcher).length )
                    || ( e.keyCode == 27 )
                ) {
                    $switcher.removeClass('switcher_active');
                }
            }
        });

        // get theme from local storage
        if(localStorage.getItem("altair_theme") !== null) {
            $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
        }


        // toggle mini sidebar

        // change input's state to checked if mini sidebar is active
        if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
            $mini_sidebar_toggle.iCheck('check');
        }

        $mini_sidebar_toggle
            .on('ifChecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.setItem("altair_sidebar_mini", '1');
                localStorage.removeItem('altair_sidebar_slim');
                location.reload(true);
            })
            .on('ifUnchecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.removeItem('altair_sidebar_mini');
                location.reload(true);
            });

        // toggle slim sidebar

        // change input's state to checked if mini sidebar is active
        if((localStorage.getItem("altair_sidebar_slim") !== null && localStorage.getItem("altair_sidebar_slim") == '1') || $body.hasClass('sidebar_slim')) {
            $slim_sidebar_toggle.iCheck('check');
        }

        $slim_sidebar_toggle
            .on('ifChecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.setItem("altair_sidebar_slim", '1');
                localStorage.removeItem('altair_sidebar_mini');
                location.reload(true);
            })
            .on('ifUnchecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.removeItem('altair_sidebar_slim');
                location.reload(true);
            });

        // toggle boxed layout

        if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
            $boxed_layout_toggle.iCheck('check');
            $body.addClass('boxed_layout');
            $(window).resize();
        }

        $boxed_layout_toggle
            .on('ifChecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.setItem("altair_layout", 'boxed');
                location.reload(true);
            })
            .on('ifUnchecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.removeItem('altair_layout');
                location.reload(true);
            });

        // main menu accordion mode
        if($sidebar_main.hasClass('accordion_mode')) {
            $accordion_mode_toggle.iCheck('check');
        }

        $accordion_mode_toggle
            .on('ifChecked', function(){
                $sidebar_main.addClass('accordion_mode');
            })
            .on('ifUnchecked', function(){
                $sidebar_main.removeClass('accordion_mode');
            });


    });
</script>


{{--<script>--}}
{{--altair_forms.parsley_validation_config();--}}
{{--</script>--}}
{{--<script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>--}}


<script src="{{ url('admin/assets/js/pages/page_contact_list.min.js') }}"></script>

<!-- datatables -->
<script src="{{ url('admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('admin/bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
<script src="{{ url('admin/assets/js/custom/datatables/buttons.uikit.js') }}"></script>
<script src="{{ url('admin/bower_components/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ url('admin/bower_components/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ url('admin/bower_components/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ url('admin/bower_components/datatables-buttons/js/buttons.colVis.js') }}"></script>
<script src="{{ url('admin/bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
<script src="{{ url('admin/bower_components/datatables-buttons/js/buttons.print.js') }}"></script>
<script src="{{ url('admin/assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>
<script src="{{ url('admin/assets/js/pages/plugins_datatables.js') }}"></script>

<!--  dropify -->
<script src="{{ url('admin/assets/js/custom/dropify/dist/js/dropify.min.js') }}"></script>

<script src="{!! asset('admin/assets/js/ion.rangeSlider.min.js') !!}"></script>
<script src="{!! asset('admin/assets/js/select2.js') !!}"></script>

<!--  forms advanced functions -->
<script src="{!! asset('admin/assets/js/pages/forms_advanced.js') !!}"></script>
<script src="{!! asset('admin/assets/js/pages/redeyeCustom.js') !!}"></script>

<script src="{{ asset('admin/bower_components/ckeditor/ckeditor.js') }} "></script>

<!-- Kendoui function -->
<script src="{{ url('admin/assets/js/kendoui_custom.min.js')}}"></script>
<script src="{{ url('admin/assets/js/pages/kendoui.min.js')}}"></script>

@yield('script')

<script>
    $(".search-select").select2();
</script>



</body>
</html>
