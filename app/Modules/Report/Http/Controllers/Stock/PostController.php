<?php

namespace App\Modules\Report\Http\Controllers\Stock;

use App\Models\Inventory\Item;
use App\Models\Moneyin\InvoiceEntry;
use App\Models\OrganizationProfile\OrganizationProfile;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ItemSubCategory;

class PostController extends Controller
{


  public function index()
  {
    $OrganizationProfile = [];
    $OrganizationProfile = OrganizationProfile::find(1);
    $current_time = Carbon::now()->toDayDateTimeString();
    $start = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
    $end = (new DateTime($current_time))->modify('+0 day')->format('Y-m-d');
    $begin_time = (new DateTime($current_time))->modify('-999999 day')->format('Y-m-d');
    $stock = [];

    $stock =  Item::all();
    $subcategories = ItemSubCategory::all();

   return view('report::Stock.index',compact('end','start','OrganizationProfile','stock','subcategories'));
  }
  
  public function filter(Request $request)
  {
    $OrganizationProfile = [];
    $OrganizationProfile = OrganizationProfile::find(1);

    $start = date('Y-m-d',strtotime($request->from_date));
    $end = date('Y-m-d',strtotime($request->to_date));

    $stock = [];

    $stock =  Item::all();
      $subcategories = ItemSubCategory::all();

    return view('report::Stock.index',compact('end','start','OrganizationProfile','stock','subcategories'));
  }
  
  public function details(Request $request,$id,$start=null,$end=null)
  {
    $OrganizationProfile=[];
    $OrganizationProfile = OrganizationProfile::find(1);
    if($request->from_date && $request->to_date){
        $start = date('Y-m-d',strtotime($request->from_date));
        $end = date('Y-m-d',strtotime($request->to_date));
    }else{
        $start = date('Y-m-d',strtotime($start));
        $end = date('Y-m-d',strtotime($end));
    }

    $stock = [];
    $stock =  Item::find($id);

    return view('report::Stock.details',compact('start','end','OrganizationProfile','stock'));
  }


}
