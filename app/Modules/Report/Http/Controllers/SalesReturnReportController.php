<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Contact\Road;
use App\Models\Inventory\Item;
use App\Models\MoneyOut\Bill;
use App\Models\Sales\FinalSales;
use Illuminate\Http\Request;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesReturnReportController extends Controller
{
    public function index(){

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $products                = Item::all();
        $roads                   = Road::all();
        $current_time            = Carbon::now()->toDayDateTimeString();
        $start                   = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                     = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::sales_return.index",compact('OrganizationProfile','companys','products','roads','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $products                   = Item::all();
        $roads                      = Road::all();
        $product_id                 = $request->product_id;
        $company_id                 = $request->company_id;
        $road_id                    = $request->road_id;
        $start_date                 = date("Y-m-d", strtotime($request->from_date));
        $end_date                   = date("Y-m-d", strtotime($request->to_date));

        $final_sales     = FinalSales::join('final_sales_return_entries','final_sales_return_entries.final_sales_id','sales_summary.id')
                                        ->leftjoin('item','item.id','final_sales_return_entries.product_id')
                                        ->when($company_id != 0, function ($query) use ($company_id) {
                                            return $query->where('sales_summary.company_id', $company_id);
                                        })
                                        ->when($product_id != 0, function ($query) use ($product_id) {
                                            return $query->where('final_sales_return_entries.product_id', $product_id);
                                        })
                                        ->when($road_id != 0, function ($query) use ($road_id) {
                                            return $query->where('sales_summary.road_id', $road_id);
                                        })
                                        ->select('sales_summary.date','sales_summary.invoice_number','item.product_code','item.item_name','item.item_sales_rate','final_sales_return_entries.quantity','sales_summary.company_id')
                                        ->whereBetween('sales_summary.date',[$start_date, $end_date])
                                        ->get();

        foreach ($final_sales as $final_sale) {
            $items[$final_sale->invoice_number][] = $final_sale;
        }

        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];
        $start                      = $request->from_date;
        $end                        = $request->to_date;
        $report_type                = $request->report_type;

        return view("report::sales_return.index",compact('OrganizationProfile','companys','products','roads','items','company_name','company_id','start','end','report_type'));
    }
}
