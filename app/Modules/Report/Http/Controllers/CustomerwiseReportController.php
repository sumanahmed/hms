<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Contact\OutletCompany;
use App\Models\Contact\Road;
use App\Models\Inventory\Item;
use App\Models\MoneyOut\Bill;
use App\Models\Sales\FinalSales;
use App\Models\Sales\PrimarySales;
use Illuminate\Http\Request;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomerwiseReportController extends Controller
{
    public function index(){

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $roads                   = Road::all();
        $customers               = Contact::where('contact_category_id', 3)->get();
        $current_time            = Carbon::now()->toDayDateTimeString();
        $start                   = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                     = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::customer.index",compact('OrganizationProfile','companys','roads','customers','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $roads                      = Road::all();
        $customers                  = Contact::where('contact_category_id', 3)->get();
        $company_id                 = $request->company_id;
        $road_id                    = $request->road_id;
        $customer_id                = $request->customer_id;
        $start_date                 = date("Y-m-d", strtotime($request->from_date));
        $end_date                   = date("Y-m-d", strtotime($request->to_date));
        $start                      = $request->from_date;
        $end                        = $request->to_date;

        if(isset($company_id) && isset($road_id) && isset($customer_id)) {

            $final_sales = FinalSales::where('company_id', $company_id)
                                        ->where('road_id', $road_id)
                                        ->where('employee_id', $customer_id)
                                        ->select('date', 'invoice_number', 'employee_id')
                                        ->whereBetween('date', [$start_date, $end_date])
                                        ->get();
            return view("report::customer.index",compact('OrganizationProfile','companys','roads','customers','final_sales','company_id','road_id','customer_id','start','end'));
        }

        if(isset($company_id) && isset($road_id) && ($road_id != 0) && (!isset($customer_id)) ) {

            $number_of_outlet   = Contact::where('road_id', $road_id)->count();
            $outlets            = Contact::where('contact_category_id', 1)->count();
            $outlet             = Contact::select('display_name')->where('road_id', $road_id)->first();
            $ordered_outlet     = $outlet['display_name'];
            $order_percentage   = (($outlets * 100) / $outlets);

            $primary_sales      = PrimarySales::where('company_id', $company_id)
                                                ->where('road_id', $road_id)
                                                ->select('date', 'invoice_number', 'employee_id')
                                                ->whereBetween('date', [$start_date, $end_date])
                                                ->first();
            $primary_sales_date = $primary_sales['date'];

            return view("report::customer.index",compact('OrganizationProfile','companys','roads','customers','number_of_outlet','ordered_outlet','order_percentage','primary_sales_date','company_id','road_id','start','end'));
        }

        if(isset($company_id) && isset($road_id) && ($road_id == 0) && (!isset($customer_id)) ) {

            $areas      = OutletCompany::join('contact','contact.id','outlet_companys.contact_id')
                                        ->where('outlet_companys.company_id', $company_id)
                                        ->select('contact.serial', 'contact.display_name', 'contact.address','contact.propietor','contact.mobile','contact.road_id')
                                        ->get();

            foreach ($areas as $area) {
                $outlets[$area->road_id][] = $area;
            }

            return view("report::customer.index",compact('OrganizationProfile','companys','roads','customers','company_id','road_id','start','end','outlets'));
        }






    }
}
