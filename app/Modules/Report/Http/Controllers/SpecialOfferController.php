<?php

namespace App\Modules\Report\Http\Controllers;
use App\Models\Inventory\SpecialOffer;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class SpecialOfferController extends Controller
{
    public function index(){
        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $current_time               = Carbon::now()->toDayDateTimeString();
        $start                      = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                        = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::special_offer.index",compact('OrganizationProfile','companys','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();

        if($request->offer_type == 1) {



            $special_offers = SpecialOffer::where('company_id', $request->company_id)
                                                ->where('from_date', '>=', $request->from_date)
                                                ->where('to_date', '<=', $request->to_date)
                                                ->get();

        }

        if($request->offer_type == 2) {

            $claims = SpecialOffer::leftjoin('bill_free_entry','bill_free_entry.special_offer_id','special_offers.company_id')
                                    ->leftjoin('bill_entry','bill_entry.id','bill_free_entry.bill_entry_id')
                                    ->leftjoin('bill_free_receive_entry','bill_free_receive_entry.bill_free_entry_id','bill_free_entry.id')
                                    ->select('special_offers.sku_id','bill_entry.quantity','special_offers.free_sku_id','special_offers.free_sku_qty',
                                            'bill_free_receive_entry.received_quantity'
                                    )
                                    ->where('special_offers.company_id', $request->company_id)
                                    ->where('special_offers.from_date', '>=', $request->from_date)
                                    ->where('special_offers.to_date', '<=', $request->to_date)
                                    ->get();

        }

        if($request->offer_type == 3) {

            $free_receives = SpecialOffer::leftjoin('bill_free_entry','bill_free_entry.special_offer_id','special_offers.company_id')
                                            ->leftjoin('bill_free_receive_entry','bill_free_receive_entry.bill_free_entry_id','bill_free_entry.id')
                                            ->select('bill_free_receive_entry.date','bill_free_receive_entry.received_quantity','special_offers.free_sku_id'
                                            )
                                            ->where('special_offers.company_id', $request->company_id)
                                            ->where('special_offers.from_date', '>=', $request->from_date)
                                            ->where('special_offers.to_date', '<=', $request->to_date)
                                            ->get();

        }

        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];
        $company_id                 = $request->company_id;
        $start                      = $request->from_date;
        $end                        = $request->to_date;
        $offer_type                 = $request->offer_type;

        return view("report::special_offer.index",compact('OrganizationProfile','companys','special_offers','claims','free_receives','company_name','company_id','start','end','offer_type'));
    }
}
