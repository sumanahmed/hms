<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Contact\Road;
use App\Models\Contact\OutletCompany;
use App\Models\OrganizationProfile\OrganizationProfile;
use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

class OutletRecordController extends Controller
{
    public function index(){

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();

        $roads                   = Road::all();

        return view("report::outlet_record.index",compact('OrganizationProfile','companys','roads'));
    }

    public function ajaxRoad($id){
        if($id != null) {
            $contact = OutletCompany::select('contact_id')->where('company_id', $id)->get();
        }
        if($id == 0) {
            $contact = null;
        }

        $roads      = Contact::join('roads','roads.id','contact.road_id')
                                ->when($contact != null, function ($query) use ($contact) {
                                    return $query->whereIn('contact.id', $contact);
                                })
                                ->when($contact == null, function ($query) use ($contact) {
                                    return $query->where('contact.contact_category_id', 1);
                                })
                                ->select('roads.id','roads.name')
                                ->distinct('roads.id')
                                ->get();

        return Response::json($roads);
    }

    public function filter(Request $request){
        $company_id              = $request->company_id;
        $road_id                 = $request->road_id;

        $outlets    = OutletCompany::join('contact','contact.id','outlet_companys.contact_id')
                                    ->join('roads','roads.id','contact.road_id')
                                    ->when($company_id != 0, function ($query) use ($company_id) {
                                        return $query->where('outlet_companys.company_id', $company_id);
                                    })
                                    ->when($road_id != 0, function ($query) use ($road_id) {
                                        return $query->where('contact.road_id', $road_id);
                                    })
                                    ->select('contact.display_name','contact.propietor','contact.mobile','contact.outlet','contact.address','outlet_companys.company_id','roads.name as road_name')
                                    //->distinct('roads.id')
                                    ->get();

        foreach ($outlets as $outlet) {
            $road[$outlet->road_id][] = $outlet;
        }

        foreach ($road as $key => $item){
            foreach ($item as $new_item){
                $company[$new_item->company_id][$key][]     = $new_item;
            }
        }

        $OrganizationProfile     = OrganizationProfile::find(1);
        $companys                = Contact::where('contact_category_id', 2)->get();
        $roads                   = Road::all();

        return view("report::outlet_record.index",compact('OrganizationProfile','outlets','company_id','road_id','companys','roads','road','company'));
    }
}
