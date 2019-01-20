<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Inventory\Item;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Contact\Contact;

class ProductController extends Controller
{
    public function index(){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $companys                   = Contact::where('contact_category_id', 2)->get();

        return view("report::product.index",compact('OrganizationProfile','companys'));
    }

    public function filter(Request $request){

        $OrganizationProfile        = OrganizationProfile::find(1);
        $items          = Item::where('company_id', $request->company_id)->get();
        $company_id     = $request->company_id;
        $company        = Contact::select('display_name')->where('id', $request->company_id)->first();
        $company_name   = $company['display_name'];
        $companys       = Contact::where('contact_category_id', 2)->get();

        return view("report::product.index",compact('OrganizationProfile','items','company_id','company_name','companys'));
    }

}
