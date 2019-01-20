<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Damage\DamageAdjustmentEntry;
use App\Models\Damage\DamageItem;
use App\Models\Inventory\Item;
use App\Models\MoneyOut\Bill;
use Illuminate\Http\Request;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FreeDetailsReportController extends Controller
{
    public function index(){

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $current_time            = Carbon::now()->toDayDateTimeString();
        $start                   = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end                     = (new DateTime($current_time))->modify('0 day')->format('d-m-Y');

        return view("report::free_detail.index",compact('OrganizationProfile','companys','products','start','end'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();
        $company_id                 = $request->company_id;
        $start_date                 = date("Y-m-d", strtotime($request->from_date));
        $end_date                   = date("Y-m-d", strtotime($request->to_date));

        /*Total Damage*/
        if( $request->free_type == 1 ) {

            $damage_items     = DamageItem::leftjoin('item','item.id','damage_items.item_id')
                                                ->leftjoin('damage_adjustment_entries','damage_adjustment_entries.item_id','item.id')
                                                ->when($company_id != 0, function ($query) use ($company_id) {
                                                    return $query->where('item.company_id', $company_id);
                                                })
                                                ->selectRaw("GROUP_CONCAT(item.company_id) as company_id, 
                                                             GROUP_CONCAT(item.item_name) as item_name, 
                                                             GROUP_CONCAT(item.item_purchase_rate) as purchase_price, 
                                                             damage_items.quantity as free_taken,
                                                             damage_adjustment_entries.quantity as free_given
                                                ")
                                                ->whereBetween('damage_items.date',[$start_date, $end_date])
                                                ->groupBy('damage_items.item_id')
                                                ->get();

            foreach ($damage_items as $damage_item) {
                $items[$damage_item['company_id']][] = $damage_item;
            }
        }
        /*Total Damage Ends*/

        /*Total Damage (Break Up)*/
        if( $request->free_type == 2 ) {

            $damage_items     = DamageItem::leftjoin('item','item.id','damage_items.item_id')
                                            ->when($company_id != 0, function ($query) use ($company_id) {
                                                return $query->where('item.company_id', $company_id);
                                            })
                                            ->select('item.item_name','item.item_purchase_rate','item.company_id',
                                                'damage_items.date','damage_items.quantity as damage_taken')
                                            ->whereBetween('damage_items.date',[$start_date, $end_date])
                                            ->get()
                                            ->sortBy('damage_items.date')
                                            ->toArray();

            $damage_adjustment_entry_items  = DamageAdjustmentEntry::rightjoin('damage_adjustments','damage_adjustments.id','damage_adjustment_entries.damage_adjustment_id')
                                                                        ->leftjoin('item','item.id','damage_adjustment_entries.item_id')
                                                                        ->when($company_id != 0, function ($query) use ($company_id) {
                                                                            return $query->where('item.company_id', $company_id);
                                                                        })
                                                                        ->select('item.item_name','item.item_purchase_rate','item.company_id',
                                                                            'damage_adjustments.date','damage_adjustment_entries.quantity as damage_given')
                                                                        ->whereBetween('damage_adjustments.date',[$start_date, $end_date])
                                                                        ->get()
                                                                        ->sortBy('damage_adjustments.date')
                                                                        ->toArray();

            $output = array_merge($damage_items, $damage_adjustment_entry_items);

            foreach ($output as $newoutput) {
                $alls[$newoutput['company_id']][] = $newoutput;
            }

            foreach ($output as $new_output) {
                $items[$new_output['date']][] = $new_output;
            }
        }
        /*Total Damage (Break Up) Ends*/

        $company                    = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name               = $company['display_name'];

        $start                      = $request->from_date;
        $end                        = $request->to_date;
        $free_type                  = $request->free_type;

        return view("report::free_detail.index",compact('OrganizationProfile','companys','alls','items','company_name','company_id','start','end','free_type'));
    }
}
