<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" ng-app="app">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no" />

    <link rel="icon" type="image/png" href="{{ url('admin/assets/img/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ url('admin/assets/img/favicon-32x32.png') }}" sizes="32x32">

    <title>@yield('title')</title>


    <!-- themes -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/themes/themes_combined.min.css') }}" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="{{ url('admin/bower_components/matchMedia/matchMedia.js') }}"></script>
    <script type="text/javascript" src="{{ url('admin/bower_components/matchMedia/matchMedia.addListener.js') }}"></script>
    <link rel="stylesheet" href="{{ url('admin/assets/css/ie.css') }}" media="all">
    <![endif]-->

    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th{
            border: 1px solid #ccc;
        }
        td {

            height: 2em;
            border: 1px solid #ccc;
        }
        @page { margin: 180px 50px; }
        #header { position: fixed; left: 0px; top: -190px; right: 0px; height: 150px;padding-top: 20px }
        #footer { position: fixed; left: 0px; bottom: -140px; right: 0px; height: 150px; }
        #footer .page:after { content: counter(page, upper-roman); }

    </style>
</head>

<body class="sidebar_main_open sidebar_main_swipe header_double_height" style="margin-top: 30px;margin-bottom: 40px">
<?php
$helper = new \App\Lib\Helpers;
?>

<div id="header">
    <div class="col-md-4">
        <img style="padding-top: 20px;" class="logo_regular" src="uploads/banner.png" alt="" height="50" width="50"/>
    </div>
    <div class="" style="text-align: center;padding-top: -70px">
        <h1 style="text-transform: uppercase">{{ $OrganizationProfile->company_name }}</h1>
        <p style="margin: 0;padding: 0">{{ $OrganizationProfile->street }},{{ $OrganizationProfile->city }},{{ $OrganizationProfile->state }},{{ $OrganizationProfile->country }}</p>
        <p>{{ $OrganizationProfile->email }},{{ $OrganizationProfile->contact_number }}</p>
    </div>

    <div>
        <div style="font-size: 12px;text-align: center">
            <div >
                <h2 style="margin: 0;padding: 0">Patient</h2>
                <p style="margin: 0;padding: 0"># PID-{{ str_pad($patient->serial, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>
</div>
<div id="footer">

    <div class="uk-grid">
        <div class="uk-width-1-2">
            <p class="uk-text-small uk-margin-bottom">Looking forward for your business.</p>
        </div>
    </div>

    <div class="uk-grid">
        <div class="uk-width-1-2" style="text-align: left">
            <p class="uk-text-small uk-margin-bottom">Customer Signature</p>
        </div>
        <div class="uk-width-1-2" style="text-align: right;padding-top: -55px">
            <p class="uk-text-small uk-margin-bottom">Company Representative</p>
        </div>

    </div>
</div>


<div class="uk-width-large-6-10">

    <div class="md-card-content invoice_content print_bg" style="margin-top: 10px;">

        <div class="container" style="font-size: 15px;">
            <div class="uk-width-small-1-2 uk-row-first" style="padding-top: -50px">
                <div class="uk-margin-bottom">
                    <span class="uk-text-muted uk-text-small uk-text-italic">Bill To: <span style="color: green">{{ $patient->name }}</span> </span>
                    <address>
                        <p style="margin: 0;padding: 0">Admit Date - {{ $patient->admission_date }}</p>
                        <p style="margin: 0;padding: 0">Age- {{ $patient->age }}</p>
                        <p style="margin: 5px;padding: 0">Gender-{{ $patient->gender == 0 ? 'Male' : 'Female' }}</p>
                    </address>
                </div>
            </div>
            <div class="uk-width-small-1-2" style="padding-top: -80px;">

            </div>
        </div>
        <br>
        <div class="uk-grid uk-margin-large-bottom" style="font-size: 12px;">
            <table width="700px">
                <thead>
                <tr>
                    <th>Particular</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @if(isset($total_bed_charge))
                        <tr class="uk-table-middle">
                            <td>Total Bed Charge</td>
                            <td>{{ number_format($total_bed_charge, 2, '.', ' ') }}</td>
                        </tr>
                    @endif

                    @if(isset($doctor_visit))
                        <tr class="uk-table-middle">
                            <td>Doctor Visit</td>
                            <td>{{ number_format($doctor_visit, 2, '.', ' ') }}</td>
                        </tr>
                    @endif

                    @if(isset($bill))
                        <tr class="uk-table-middle">
                            <td>Test Charge</td>
                            <td>{{ number_format($bill, 2, '.', ' ') }}</td>
                        </tr>
                    @endif

                    @php
                        $total_bed_charge   = isset($total_bed_charge) ? $total_bed_charge : 0;
                        $doctor_visit       = isset($doctor_visit) ? $doctor_visit : 0;
                        $bill               = isset($bill) ? $bill : 0;

                        $total              = ($total_bed_charge + $doctor_visit + $bill);
                    @endphp

                    <tr class="uk-table-middle">
                        <td>Total</td>
                        <td>{{ number_format($total, 2, '.', ' ')}}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>
