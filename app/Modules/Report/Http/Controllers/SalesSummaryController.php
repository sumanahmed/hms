<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Sales\FinalSales;
use Illuminate\Http\Request;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class SalesSummaryController extends Controller
{
    public function index(){
        $OrganizationProfile  = OrganizationProfile::find(1);
        $final_sales_invoices = FinalSales::select("invoice_number")->get();

        return view("report::sales_summary.index",compact('OrganizationProfile','final_sales_invoices'));
    }

    public function filter(Request $request){

        $OrganizationProfile    = OrganizationProfile::find(1);
        $final_sales_invoices   = FinalSales::select("invoice_number")->get();
        $final_sales            = FinalSales::join('final_sales_entries','final_sales_entries.final_sales_id','final_sales.id')
                                            ->join('final_sales_return_entries','final_sales_return_entries.final_sales_id','final_sales.id')
                                            ->join('final_sales_free_entries','final_sales_free_entries.final_sales_id','final_sales.id')
                                            ->leftjoin('item','item.id','final_sales_entries.product_id')
                                            ->select('item.item_name',
                                                'final_sales_entries.quantity',
                                                'final_sales_entries.company_rate',
                                                'final_sales_return_entries.quantity as return_quantity',
                                                'final_sales_free_entries.quantity as free_quantity',
                                                'final_sales.invoice_number','final_sales.company_id',
                                                'final_sales.employee_id','final_sales.road_id','final_sales.date'
                                            )
                                            ->where('invoice_number', $request->invoice_number)
                                            ->where('final_sales_return_entries.free', 0)
                                            ->get();

        $invoice_number         = $request->invoice_number;

        return view("report::sales_summary.index",compact('OrganizationProfile','final_sales_invoices','final_sales','invoice_number'));
    }
}
