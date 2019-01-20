<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Inventory\Item;
use App\Models\MoneyOut\Bill;
use Illuminate\Http\Request;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UndeliveredReportController extends Controller
{
    public function index(){

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $products                = Item::all();
        $current_time            = Carbon::now()->toDayDateTimeString();
        $start                   = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                     = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::undelivered_products.index",compact('OrganizationProfile','companys','products','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $products                   = Item::all();
        $product_id                 = $request->product_id;
        $company_id                 = $request->company_id;
        $start_date                 = date("Y-m-d", strtotime($request->from_date));
        $end_date                   = date("Y-m-d", strtotime($request->to_date));

        if( ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) && $request->record_type == 1 ) {

            $current_undelivered_items     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                                    ->join('item','item.id','bill_entry.item_id')
                                                    ->when($product_id != 0, function ($query) use ($product_id) {
                                                        return $query->where('bill_entry.item_id', $product_id);
                                                    })
                                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                                        return $query->where('bill.company_id', $company_id);
                                                    })
                                                    ->select('bill_entry.rate','bill_entry.undelivered_quantity','bill.company_id','item.item_name')
                                                    ->whereBetween('bill.bill_date',[$start_date, $end_date])
                                                    ->get();

            foreach ($current_undelivered_items as $current_undelivered_item) {
                $items[$current_undelivered_item->company_id][] = $current_undelivered_item;
            }
        }

        if( ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) && $request->record_type == 1 && $request->invoice == 1  ) {

            $current_undelivered_items     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                                    ->join('item','item.id','bill_entry.item_id')
                                                    ->when($product_id != 0, function ($query) use ($product_id) {
                                                        return $query->where('bill_entry.item_id', $product_id);
                                                    })
                                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                                        return $query->where('bill.company_id', $company_id);
                                                    })
                                                    ->select('bill_entry.rate','bill_entry.quantity','bill_entry.undelivered_quantity','bill.company_id','bill.bill_date','bill.bill_number','item.item_name')
                                                    ->whereBetween('bill.bill_date',[$start_date, $end_date])
                                                    ->get();

            foreach ($current_undelivered_items as $current_undelivered_item) {
                $items[$current_undelivered_item->company_id][] = $current_undelivered_item;
            }
        }

        if( ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) && $request->record_type == 2) {

            $undelivered_receive_records     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                                    ->join('item','item.id','bill_entry.item_id')
                                                    ->when($product_id != 0, function ($query) use ($product_id) {
                                                        return $query->where('bill_entry.item_id', $product_id);
                                                    })
                                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                                        return $query->where('bill.company_id', $company_id);
                                                    })
                                                    ->select('bill_entry.rate','bill_entry.quantity','bill_entry.undelivered_quantity','bill_entry.delivered_quantity','bill.company_id','item.item_name')
                                                    ->whereBetween('bill.bill_date',[$start_date, $end_date])
                                                    ->get();

            foreach ($undelivered_receive_records as $undelivered_receive_record) {
                $items[$undelivered_receive_record->company_id][] = $undelivered_receive_record;
            }
        }


        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];
        $invoice                    = $request->invoice;
        $start                      = $request->from_date;
        $end                        = $request->to_date;
        $report_type                = $request->report_type;
        $record_type                = $request->record_type;

        return view("report::undelivered_products.index",compact('OrganizationProfile','companys','products','items','company_name','company_id','invoice','start','end','report_type','record_type'));
    }
}
