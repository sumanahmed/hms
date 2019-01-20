<!doctype html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ticket Refund</title>
    
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style>
    
    
        </style>
    
    </head>
    
    <body style="font-family: freeserif; font-size: 10pt;">
    
        <div role="main" class="container">
    
        <div class="col-md-4">
            <img style="width: 100px;height: 50px;margin-left: -30px" src="{!! asset('uploads/op-logo/'.$logo->logo) !!}" alt="">
        </div>
        <div class="row">
            <div class="col-md-4" style="text-align: center;padding-top: -90px;padding-left: 80px">
                <h1 style="font-weight: 900;text-transform: uppercase;color: green;font-size: 25px">{!! $logo->company_name !!}</h1>
                <h6 style="font-weight: 400;text-transform: uppercase">({!! $logo->street !!}, {!! $logo->city !!}, {!! $logo->state !!}, {!! $logo->country !!}, {!! $logo->zip_code !!}, {!! $logo->contact_number !!}, {!! $logo->email !!}, {!! $logo->website !!})</h6>
            </div>
        </div>
        <br>
    
        <div class="row" style="border: 1px solid green">
            <div class="col-md-4">
                
                
                @foreach($contact as $value)
                    @if($refund->customer_id == $value->id)
                        <h5>Customer Name: {!! $value->display_name !!}</h5>
                    @endif
                @endforeach
                
                @foreach($contact as $value)
                    @if($refund->vendor_id == $value->id)
                        <h5>Vendor Name: {!! $value->display_name !!}</h5>
                    @endif
                @endforeach
    
                <h5>Submit Date: {!! $refund->submit_date !!}</h5>
                <h5>IATA Submit Date: {!! $refund->iata_submit_date !!}</h5>
                <h5>Name: {!! $refund->first_name !!} {!! $refund->last_name !!}</h5>
    
            </div>
            <div class="col-md-4" style="padding-left: 400px;padding-top: -140px">
    
                <h5>Ticket Number: {!! $refund->ticket_number !!}</h5>
                
                @foreach($item as $value)
                    @if($refund->refund_sector == $value->id)
                        <h5>Refund Sector: {!! $value['item_name'] !!}</h5>
                    @endif
                @endforeach
    
                <h5>Receive Date: {!! $refund->receive_date !!}</h5>
                <h5>Issue Date: {!! $refund->issue_date !!}</h5>
                <h5>Statement Date: {!! $refund->statement_date !!}</h5>
            </div>
    
        </div>
        <br>
    
        <h4 style="text-transform: uppercase;text-decoration: underline;color: green">Invoice:</h4>
    
        <div class="row">
            <div class="col-md-4">
               @foreach($item as $value)
                  @if($refund->invoice)
                        @if($refund->invoice['OrderInvoiceEntries']['item_id'] == $value['id'])
                            <h6 style="text-transform: uppercase">Particular : {!! $value->item_name !!}</h6>
                        @endif
                    @endif
                @endforeach
            </div>
            <div class="col-md-4" style="padding-left: 250px;padding-top: -35px">
                <h6 style="text-transform: uppercase">{!! $refund->invoice? "Quantity: " . $refund->invoice['OrderInvoiceEntries']['quantity'] : '' !!}</h6>
            </div>
            <div class="col-md-4" style="padding-left: 480px;padding-top: -35px">
                <h6 style="text-transform: uppercase">{!! $refund->invoice? "Rate: " . $refund->invoice['OrderInvoiceEntries']['rate'] : '' !!}</h6>
            </div>
    
        </div>
    
        <br>
        <h4 style="text-transform: uppercase;text-decoration: underline;color: green">Bill:</h4>
    
        <div class="row">
            <div class="col-md-4">
                @foreach($item as $value)
                    @if($refund->bill)
                        @if($refund->bill['OrderbillEntries']['item_id'] == $value['id'])
                            <h6 style="text-transform: uppercase">Particular : {!! $value->item_name !!}</h6>
                        @endif
                    @endif
                @endforeach
            </div>
            <div class="col-md-4" style="padding-left: 250px;padding-top: -35px">
                <h6 style="text-transform: uppercase">{!! $refund->bill ? "Quantity: " . $refund->bill['OrderbillEntries']['quantity'] : '' !!}</h6>
            </div>
            <div class="col-md-4" style="padding-left: 480px;padding-top: -35px">
                <h6 style="text-transform: uppercase">{!! $refund->bill ? "Rate: " . $refund->bill['OrderbillEntries']['rate'] : '' !!}</h6>
            </div>
    
        </div>
    
        <br>
    
    </div>
    
    </body>
    
</html>