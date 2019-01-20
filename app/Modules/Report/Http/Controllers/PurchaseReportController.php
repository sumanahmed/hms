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

class PurchaseReportController extends Controller
{
    public function index(){
        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $products                = Item::all();
        $current_time            = Carbon::now()->toDayDateTimeString();
        $start                   = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                     = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::purchase.index",compact('OrganizationProfile','companys','products','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $products                   = Item::all();
        $product_id                 = $request->product_id;
        $company_id                 = $request->company_id;

        if($request->report_type == 0 || $request->report_type == 2) {
            $purchases     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                    ->join('item','item.id','bill_entry.item_id')
                                    ->when($product_id != 0, function ($query) use ($product_id) {
                                        return $query->where('bill_entry.item_id', $product_id);
                                    })
                                    ->select('bill.bill_date','bill.company_invoice','bill.bill_number','bill_entry.item_id','bill_entry.rate','bill_entry.quantity',
                                        'bill_entry.undelivered_quantity','bill_entry.delivered_quantity','bill_entry.amount','bill.company_id','item.item_name')
                                    ->where('bill.bill_date', '>=', $request->from_date)
                                    ->where('bill.bill_date', '<=', $request->to_date)
                                    ->get();

            foreach ($purchases as $purchase) {
                $alls[$purchase->company_id][] = $purchase;
            }
        }

        if($request->report_type == 1) {
            $purchases     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                    ->join('item','item.id','bill_entry.item_id')
                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                        return $query->where('bill.company_id', $company_id);
                                    })
                                    ->select('bill.bill_date','bill.company_invoice','bill.bill_number','bill_entry.item_id','bill_entry.rate','bill_entry.quantity',
                                        'bill_entry.undelivered_quantity','bill_entry.delivered_quantity','bill_entry.amount','bill.company_id','item.item_name')

                                    ->where('bill.bill_date', '>=', $request->from_date)
                                    ->where('bill.bill_date', '<=', $request->to_date)
                                    ->get();

            foreach ($purchases as $purchase) {
                $alls[$purchase->company_id][] = $purchase;
            }
        }


        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];
        $start                      = $request->from_date;
        $end                        = $request->to_date;
        $report_type                = $request->report_type;

        return view("report::purchase.index",compact('OrganizationProfile','companys','products','alls','company_name','company_id','start','end','report_type'));
    }

}
