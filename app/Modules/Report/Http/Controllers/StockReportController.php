<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Damage\DamageItem;
use Illuminate\Http\Request;
use App\Models\Inventory\Item;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;
use DB;
use App\Models\MoneyOut\Bill;

class StockReportController extends Controller
{
    public function index(){
        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $products                = Item::all();

        return view("report::stock.index",compact('OrganizationProfile','companys','products'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $products                   = Item::all();
        $product_id                 = $request->product_id;
        $company_id                 = $request->company_id;

        /*Saleable Products*/
            if( $request->report_for == 0 && ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) ) {

            $stock_items   = Item::select('item_name','item_purchase_rate','total_purchases','total_sales','total_purchase_return','company_id')
                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                        return $query->where('company_id', $company_id);
                                    })
                                    ->when($product_id != 0, function ($query) use ($product_id) {
                                        return $query->where('id', $product_id);
                                    })
                                    ->get();

            foreach ($stock_items as $stock_item) {
                $items[$stock_item->company_id][] = $stock_item;
            }
        }
        /*Saleable Products End*/

        /*Undelivered Products*/
            if( $request->report_for == 1 && ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) ) {
            $undeliverd_items     = Bill::join('bill_entry','bill_entry.bill_id','bill.id')
                                            ->join('item','item.id','bill_entry.item_id')
                                            ->when($company_id != 0, function ($query) use ($company_id) {
                                                return $query->where('bill.company_id', $company_id);
                                            })
                                            ->when($product_id != 0, function ($query) use ($product_id) {
                                                return $query->where('bill_entry.item_id', $product_id);
                                            })
                                            ->select('bill_entry.undelivered_quantity','bill.company_id','bill_entry.amount','bill_entry.rate','item.item_name')
                                            ->get();

            foreach ($undeliverd_items as $undeliverd_item) {
                $items[$undeliverd_item->company_id][] = $undeliverd_item;
            }
        }
        /*Undelivered Products Ends*/

        /*Damaged Products*/
            if( $request->report_for == 2 && ($request->report_type == 0 || $request->report_type == 1 || $request->report_type == 2) ) {
            $deliverd_items     = DamageItem::join('item','item.id','damage_items.item_id')
                                            ->when($company_id != 0, function ($query) use ($company_id) {
                                                return $query->where('item.company_id', $company_id);
                                            })
                                            ->when($product_id != 0, function ($query) use ($product_id) {
                                                return $query->where('damage_items.item_id', $product_id);
                                            })
                                            ->select('damage_items.quantity','item.company_id','item.item_purchase_rate','item.item_name')
                                            ->get();

            foreach ($deliverd_items as $deliverd_item) {
                $items[$deliverd_item->company_id][] = $deliverd_item;
            }

        }
        /*Damaged Products Ends*/

        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];
        $report_type                = $request->report_type;
        $report_for                 = $request->report_for;
        $current_time               = Carbon::now()->toDayDateTimeString();
        $date                       = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::stock.index",compact('OrganizationProfile','companys','products','items','company_name','company_id','report_type','report_for','date'));
    }
}
