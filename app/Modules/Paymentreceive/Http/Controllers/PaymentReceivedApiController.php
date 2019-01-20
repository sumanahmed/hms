<?php

namespace App\Modules\Paymentreceive\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Moneyin\PaymentReceiveEntryModel;
use App\Models\Moneyin\PaymentReceives;
use App\Models\Moneyin\Invoice;
use App\Models\AccountChart\Account;
use App\Models\Contact\Contact;

use DB;

class PaymentReceivedApiController extends Controller
{
    public function getCustomerList()
    {
        $contacts = DB::table('contact')->select('display_name as text', 'id as value')->get();
        $paid_receives  = DB::table('account')->select('account_name as text', 'id as value')
            ->whereIn('account_type_id',[4,5])->get();

        return response()->json([
            'customer'         =>  $contacts,
            'paid_receives'  =>  $paid_receives,
        ], 201);
    }

    public function getCustomerInvoice($customer_id)
    {
        $invoices = Invoice::where('customer_id', $customer_id)->where('due_amount', '>', 0)->where('save', null)->get();
        $customer = Contact::find($customer_id);

        return response()->json([
            'invoices'      => $invoices,
            'customer'      => $customer,
        ], 201);
    }

    public function getCustomerInvoiceEdit($payment_receive_id)
    {
        $invoice_id_array       = [];
        $i                      = 0;
        $invoices_id            = PaymentReceiveEntryModel::where('payment_receives_id', $payment_receive_id)->select('invoice_id')->get();
        $payment_receive        = PaymentReceives::where('id', $payment_receive_id)->get();

        foreach ($invoices_id as $invoice_id)
        {
            $invoice_id_array[$i++] = $invoice_id['invoice_id'];
        }

        $invoices_pr_entry               = Invoice::whereIn('id', $invoice_id_array)->get()->toArray(); //showing invoices used in payment receive only
        $invoices_due                    = Invoice::where('customer_id', $payment_receive[0]['customer_id'])->where('due_amount', '>', 0)->where('save', null)->get()->toArray(); //showing all due invoices

        $invoices_merge                  = array_merge($invoices_pr_entry, $invoices_due);
        $invoices                        = array_unique($invoices_merge, SORT_REGULAR);

        return response()->json([
            'invoices'           =>  $invoices,
            'invoice_id_array'   =>  $invoice_id_array,
        ], 201);
    }

    public function getPaymentReceiveEntry($payment_receive_id)
    {
        $payment_receive_entry          = PaymentReceiveEntryModel::where('payment_receives_id', $payment_receive_id)->get();
        $payment_receive_amount         = PaymentReceives::find($payment_receive_id)->amount;
        $payment_receive_excess_payment = PaymentReceives::find($payment_receive_id)->excess_payment;
        $vat_adjustment_amount          = PaymentReceives::find($payment_receive_id)->vat_adjustment;
        $tax_adjustment_amount          = PaymentReceives::find($payment_receive_id)->tax_adjustment;
        $others_adjustment_amount       = PaymentReceives::find($payment_receive_id)->others_adjustment;
        $customer_id                    = PaymentReceives::find($payment_receive_id)->customer_id;
        $account_id                     = PaymentReceives::find($payment_receive_id)->account_id;
        $contacts                       = DB::table('contact')->select('display_name as text', 'id as value')->get();
        $paid_receives                  = DB::table('account')->select('account_name as text', 'id as value')
                                                              ->whereIn('account_type_id',[4,5])->get();

        return response()->json([
            'payment_receive_entry'             =>  $payment_receive_entry,
            'vat_adjustment_amount'             =>  $vat_adjustment_amount,
            'tax_adjustment_amount'             =>  $tax_adjustment_amount,
            'others_adjustment_amount'          =>  $others_adjustment_amount,
            'customer'                          =>  $contacts,
            'customer_id'                       =>  $customer_id,
            'payment_receive_amount'            =>  $payment_receive_amount,
            'payment_receive_excess_payment'    =>  $payment_receive_excess_payment,
            'paid_receives'                     =>  $paid_receives,
            'account_id'                        =>  $account_id,
        ], 201);
    }
}
