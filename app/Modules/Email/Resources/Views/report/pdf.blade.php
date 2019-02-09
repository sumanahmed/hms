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
            padding-left:10px;
        }
        td {

            height: 2em;
            border: 1px solid #ccc;
            padding-left:10px;
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
@inject('theader', '\App\Lib\TemplateHeader')

<div id="header">
    <div class="md-card-content invoice_content print_bg">
        @if($theader->getBanner()->headerType)
            <div class="" style="text-align: center;">
                <img style="width:800px; height:200px;" src="{{ asset($theader->getBanner()->file_url) }}">
            </div>
        @else
            <div class="uk-grid" data-uk-grid-margin style="text-align: center; margin-top:50px;">
                <h1 style="width: 100%; text-align: center;"><img style="text-align: center;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="15" width="71"/> {{ $OrganizationProfile->company_name }}</h1>
            </div>
            <div class="" style="text-align: center;">
    
                <p>{{ $OrganizationProfile->street }},{{ $OrganizationProfile->city }},{{ $OrganizationProfile->state }},{{ $OrganizationProfile->country }}</p>
    
                <p style="margin-top: -17px;">{{ $OrganizationProfile->email }},{{ $OrganizationProfile->contact_number }}</p>
            </div>
        @endif
    </div>
    <div>
        <div style="font-size: 12px;text-align: center">
            <div >
                <h2 style="margin: 0;padding: 0">Patient</h2>
                <p style="margin: 0;padding: 0"># PID-{{ str_pad($patient['serial'], 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>
</div>
<div id="footer">

    <div class="uk-grid">
        <div class="uk-width-1-2" style="text-align: left">
            <p class="uk-text-small uk-margin-bottom">Laboratorist Signature</p>
        </div>
        <div class="uk-width-1-2" style="text-align: right;padding-top: -55px">
            <p class="uk-text-small uk-margin-bottom">Authority Signature</p>
        </div>

    </div>
</div>


<div class="uk-width-large-6-10">

    <div class="md-card-content invoice_content print_bg" style="margin-top: 80px;">

        <div class="uk-grid">
            <div class="uk-width-small-1-3 uk-row-first">
                <div class="uk-margin-bottom">
                    <table>
                        <tr>
                            <td>Patient ID</td>
                            <td>{{ $helper->getPatientSerial($report->patient_id) }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $helper->getPatientName($report->patient_id) }}</td>
                        </tr>
                        <tr>
                            <td>Reffered By</td>
                            <td>{{ $report->doctor->name }}</td>
                        </tr>`
                        <tr>
                            <td>Speciment</td>
                            <td>{{ $report->test_category->name }}</td>
                        </tr>
                        <tr>
                            <td>Received Date</td>
                            <td>{{ $report->taking_date }}</td>
                        </tr>
                        <tr>
                            <td>Delivery Date</td>
                            <td>{{ $report->delivery_date }}</td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td>{{ $helper->getPatientAge($report->patient_id)." Year" }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        

        <div class="uk-grid">
            <div class="uk-width-small-1-1">
                <div class="uk-margin-bottom">
                    <h3>Report Details</h3>
                    <table id="table_center" border="1" class="uk-table">
                        <thead>
                            <tr class="uk-text-upper">
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Blood Group</td>
                                <td>{{ $report->blood_group }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Amikacin</td>
                                <td>{{ $report->amikacin." %" }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Organism Isolated</td>
                                <td>{{ $report->organism_isolated." %" }}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Hemoglobin</td>
                                <td>{{ $report->hemoglobin." %" }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>White Blood cell</td>
                                <td>{{ $report->white_blood_sell." %" }}</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Red Blood cell</td>
                                <td>{{ $report->red_blood_sell." %" }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Neutrophil</td>
                                <td>{{ $report->neutrophil." %" }}</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Basophil</td>
                                <td>{{ $report->basophil." %" }}</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>MPV</td>
                                <td>{{ $report->mpv." %" }}</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>MCV</td>
                                <td>{{ $report->mcv." %" }}</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>MCH</td>
                                <td>{{ $report->mch." %" }}</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>PDW</td>
                                <td>{{ $report->pdw." %" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>

</html>
