<?php

namespace App\Modules\Report\Http\Controllers;


use App\Models\MoneyOut\Bill;
use App\Models\MoneyOut\BillEntry;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;



class PurchaseByVendorController extends Controller
{
    public function index(Request $request)
    {
        if (($request->from_date) != null && ($request->to_date) != null) {
            $start = date('Y-m-d', strtotime($request->from_date));
            $end = date('Y-m-d', strtotime($request->to_date));
        } else {
            $current_time = Carbon::now()->toDayDateTimeString();
            $start = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
            $end = (new DateTime($current_time))->modify('+0 day')->format('Y-m-d');
        }


        $bill = Bill::whereBetween('bill_date', [$start, $end])
            ->join('contact', 'contact.id', 'bill.vendor_id')
            ->join('payment_made_entry', 'payment_made_entry.bill_id', 'bill.id')
            ->groupBy('bill.vendor_id')
            ->selectRaw('bill.vendor_id as vendor_id, contact.display_name as name, sum(bill.amount) as total_purchase, sum(payment_made_entry.amount) as total_payment')
            ->get();
        //dd($bill);


        return view('report::PurchaseByVendor.index', compact('start', 'end', 'bill'));
    }

    public function details(Request $request, $id, $start, $end)
    {
        if (($request->from_date) != null && ($request->to_date) != null) {
            $start = date('Y-m-d', strtotime($request->from_date));
            $end = date('Y-m-d', strtotime($request->to_date));
        } else {
            $current_time = Carbon::now()->toDayDateTimeString();
            $start = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
            $end = (new DateTime($current_time))->modify('+0 day')->format('Y-m-d');
        }
        $data = BillEntry::join('bill', 'bill_entry.bill_id', 'bill.id')
            ->join('item', 'item.id', 'bill_entry.item_id')
            ->whereBetween('bill.bill_date', [$start, $end])
            ->where('bill.vendor_id', $id)
            ->selectRaw(
                'bill_entry.id as id ,
                bill.bill_date as date, 
                bill.bill_number as transaction_number,
                  item.item_name as particulars, 
                  bill_entry.quantity as quantity,
                 bill_entry.amount as payable,
                 bill.amount as total_payable,
                    bill.due_amount as due_amount')
            ->get();

        //dd($data);
        return view('report::PurchaseByVendor.details', compact('id', 'start', 'end', 'data'));
    }
}
