<?php

namespace App\Modules\Inventory\Http\Controllers;

use App\Models\Contact\Contact;
use App\Models\Inventory\Item;
use Illuminate\Http\Request;
use App\Models\Inventory\SpecialOffer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SpecialOfferController extends Controller
{
    public function index(){
        $offers  =  SpecialOffer::join('item','item.id','special_offers.sku_id')
                                ->join('contact','contact.id','special_offers.company_id')
                                ->select('special_offers.*','item.product_code','contact.display_name')
                                ->get();
        return view("inventory::special_offer.index",compact('offers'));
    }

    public function create(){

        $company    = Contact::select('id','display_name')->where('contact_category_id', 2)->get();
        $products   = Item::select('product_code','id')->get();
       
        return view("inventory::special_offer.create",compact('company','products'));
    }

    public function store(Request $request){

        $this->validate($request,[
            'from_date'     =>  'required',
            'to_date'       =>  'required',
            'company_id'    =>  'required',
            'sku_id'        =>  'required',
            'sku_qty'       =>  'required',
            'free_sku_id'   =>  'required',
            'free_sku_qty'  =>  'required',
        ]);

        $special_offer               = new SpecialOffer();

        $special_offer->from_date           = $request->from_date;
        $special_offer->to_date             = $request->to_date;
        $special_offer->company_id          = $request->company_id;
        $special_offer->sku_id              = $request->sku_id;
        $special_offer->sku_qty             = $request->sku_qty;
        $special_offer->free_sku_id         = $request->free_sku_id;
        $special_offer->free_sku_qty        = $request->free_sku_qty;
        $special_offer->status              = 0;        
        $special_offer->created_by          = 1;
        $special_offer->updated_by          = 1;

        if($special_offer->save()){
            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Special Offer added successfully!');
        }else{
            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Something went wrong');
        }
    }

    public function edit($id){

        $special_offer  = SpecialOffer::find($id);
        $company        = Contact::select('id','display_name')->where('contact_category_id', 2)->get();
        $products       = Item::select('product_code','id')->get();
        return view("inventory::special_offer.edit",compact('special_offer','company','products'));
    }

    public function update(Request $request, $id){

        $this->validate($request,[
            'from_date'     =>  'required',
            'to_date'       =>  'required',
            'company_id'    =>  'required',
            'sku_id'        =>  'required',
            'sku_qty'       =>  'required',
            'free_sku_id'   =>  'required',
            'free_sku_qty'  =>  'required',
        ]);

        $special_offer                      = SpecialOffer::find($id);

        $special_offer->from_date           = $request->from_date;
        $special_offer->to_date             = $request->to_date;
        $special_offer->company_id          = $request->company_id;
        $special_offer->sku_id              = $request->sku_id;
        $special_offer->sku_qty             = $request->sku_qty;
        $special_offer->free_sku_id         = $request->free_sku_id;
        $special_offer->free_sku_qty        = $request->free_sku_qty;
        $special_offer->status              = 0;
        $special_offer->created_by          = 1;
        $special_offer->updated_by          = 1;

        if($special_offer->update()){

            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Special Offer Updated successfully!');
        }else{
            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Something went wrong');
        }
    }

    public function destroy($id){

        $special_offer = SpecialOffer::find($id);

        if($special_offer->delete()){
            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Special Offer deleted successfully!');
        }else{
            return redirect()
                ->route('special_offer')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Special Offer not deleted!Something went wrong');
        }

    }

    public function saveClaim($id){
        $special_offer  = SpecialOffer::find($id);
        $company        = Contact::select('id','display_name')->where('contact_category_id', 2)->get();
        $products       = Item::select('product_code','id')->get();
        return view("inventory::special_offer.claim",compact('special_offer','company','products'));
    }

}
