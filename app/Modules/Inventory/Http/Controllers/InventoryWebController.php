<?php

namespace App\Modules\Inventory\Http\Controllers;

use App\Models\Contact\Contact;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Company\Company;
use App\Models\Moneyin\InvoiceEntry;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

// Models
use App\Models\Branch\Branch;
use App\Models\Inventory\Item;
use App\Models\Inventory\ItemCategory;
use App\Models\Inventory\ItemSubCategory;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductPhase;
use App\Models\Inventory\ProductPhaseItem;
use App\Models\Inventory\Stock;
use App\Models\AccountChart\Account;
use App\Models\Tax;
use App\Models\MoneyOut\BillEntry;
use Response;
use Session;
use DB;

class InventoryWebController extends Controller
{
    public function apiAllInventory()
    {

       try{
           $items  =   Item::join('contact','contact.id','item.company_id')->select('item.*','contact.display_name')->get();

           return response($items);
       }catch (\Exception $exception){

           return response([]);
       }

    }
    public function apiFindInventory()
    {
        try{
            $items  =   Item::join('contact','contact.id','item.company_id')->select('item.*','contact.display_name')->get();

            return response($items);

        }catch (\Exception $exception){

            return response([]);
        }

    }

    public function index()
    {
        $items  =   Item::join('contact','contact.id','item.company_id')->select('item.*','contact.display_name')->get();

        $item_categories = ItemCategory::select("item_category_name",'id')->get();
        $current_time = Carbon::now()->toDayDateTimeString();
        $start = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
        $end = (new DateTime($current_time))->modify('+1 day')->format('Y-m-d');
        $stock_report = route("report_stock_details_item",["id"=>'new_id',"start"=>$start,'end'=>$end]);
        $item_report = route("report_account_item_details",["id"=>'new_id',"start"=>$start,'end'=>$end]);

        return view('inventory::inventory.Ajax.index', compact('item_report','stock_report','items','item_categories'));
    }

    public function create()
    {
        $item_categories = ItemCategory::all();
        $item_sub_categories = ItemSubCategory::all();
        $accounts = Account::all();
        $branches = Branch::all();
        $taxs     = Tax::all();
        $company =  [];
        $confirmation_id = null;
        $order_id = null;

        /* Product Code */

            $items = Item::all();

            if(count($items)>0){
                $item = Item::select('product_code')->orderBy('created_at', 'desc')->first();
                $product_code = trim($item['product_code'], "SKU-");
                $product_code = $product_code + 1;
            }else{
                $product_code = 1;
            }

            $product_code = "SKU-".str_pad($product_code, 6, '0', STR_PAD_LEFT);

        /* Product Code Ends*/

        $comapny  = Contact::select('id','display_name')->where('contact_category_id', 2)->get();

        return view('inventory::inventory.create', compact('company','item_categories','item_sub_categories', 'accounts', 'branches','taxs','confirmation_id','order_id', 'product_code', 'comapny'));
    }

    public  function subCategory($id){
        $data = ItemSubCategory::where('item_category_id',$id)->get()->toArray();
        return Response::json($data);
    }

    public function store(Request $request)
    {
        $item_data = $request->all();

        try {

            $validator = Validator::make($request->all(), [
                'entry_date'            => 'required',
                'product_code'          => 'required',
                'company_id'            => 'required',
                'item_name'             => 'required',
                'curtoon_size'          => 'required',
                'unit_type'             => 'required',
            ]);

            if ($validator->fails()) {
                return redirect::back()->withErrors($validator);
            }

            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;

            $item = new Item;

            $item->entry_date           = $item_data['entry_date'];
            $item->product_code         = $item_data['product_code'];
            $item->item_name            = $item_data['item_name'];
            $item->company_id           = $item_data['company_id'];
            $item->curtoon_size         = $item_data['curtoon_size'];
            $item->unit_type            = $item_data['unit_type'];
            $item->item_sales_rate      = $item_data['item_sales_rate'];
            $item->item_purchase_rate   = $item_data['item_purchase_rate'];
            $item->note                 = $item_data['note'];
            $item->branch_id            = 1;
            $item->created_by           = $created_by;
            $item->updated_by           = $updated_by;

             if($request->hasFile('image')){
                 $image = $request->file('image');
                 $imageName = time().".".$image->getClientOriginalExtension();
                 $directory = 'uploads/images/product/';
                 $image->move($directory, $imageName);
                 $imageUrl = $directory.$imageName;
                 $item->image = $imageUrl;
             }

            if($item->save())
            {
                if(!empty($request->confirmation_id)){
                    return redirect()
                        ->route('confirmation_edit',$request->confirmation_id)
                        ->with('alert.status', 'success')
                        ->with('alert.message', 'Item added successfully!');
                }
                if(!empty($request->order_id)){
                    return redirect()
                        ->route('confirmation_create',$request->order_id)
                        ->with('alert.status', 'success')
                        ->with('alert.message', 'Item added successfully!');
                }
                return redirect()
                    ->route('inventory')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Item added successfully!');
            }
            else
                {

                  throw new \Exception("something went wrong");
            }
        }
        catch (\Exception $e)
        {
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Refresh or reload the page and try again.');
        }
    }

    public function show($id)
    {
        $item = Item::join('contact','contact.id','item.company_id')->select('item.*','contact.display_name')->where('item.id', $id)->first();

        $item_categories = ItemCategory::all();
        $item_sub_categories = ItemSubCategory::find($id);
        return view('inventory::inventory.show', compact('item','item_categories','item_sub_categories'));
    }

    public function edit($id)
    {
        $item_categories = ItemCategory::all();
        $item_sub_categories = ItemSubCategory::all();
        $accounts = Account::all();
        $branches = Branch::all();
        $item = Item::join('contact','contact.id','item.company_id')->select('item.*','contact.display_name')->where('item.id', $id)->first();
        $taxs     = Tax::all();
        $comapny  = Contact::select('id','display_name')->where('contact_category_id', 2)->get();

        return view('inventory::inventory.edit', compact('comapny','accounts', 'branches', 'item_categories','item_sub_categories', 'item', 'id','taxs'));
    }

    public function update(Request $request, $id)
    {
        $item_data = $request->all();

        $item = Item::find($id);

        try {

            $validator = Validator::make($request->all(), [
                'entry_date'            => 'required',
                'product_code'          => 'required',
                'company_id'            => 'required',
                'item_name'             => 'required',
                'curtoon_size'          => 'required',
                'unit_type'             => 'required',
            ]);

            if ($validator->fails()) {
                return redirect::back()->withErrors($validator);
            }

            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;

            $item->entry_date           = $item_data['entry_date'];
            $item->product_code         = $item_data['product_code'];
            $item->item_name            = $item_data['item_name'];
            $item->company_id           = $item_data['company_id'];
            $item->curtoon_size         = $item_data['curtoon_size'];
            $item->unit_type            = $item_data['unit_type'];
            $item->item_sales_rate      = $item_data['item_sales_rate'];
            $item->item_purchase_rate   = $item_data['item_purchase_rate'];
            $item->note                 = $item_data['note'];
            $item->branch_id            = 1;
            $item->created_by           = $created_by;
            $item->updated_by           = $updated_by;

            if($request->hasFile('image')){
                if(!empty($item->image)){
                    unlink($item->image);
                }
                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $directory = 'uploads/images/product/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;
                $item->image = $imageUrl;
            }

            if($item->update()){
                return redirect()
                    ->route('inventory')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Item update successfully!');
            }else{

                throw new \Exception("something went wrong");
            }
        }
        catch (\Exception $e){ dd($e->getMessage());
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Refresh or reload the page and try again.');
        }
    }

    public function destroy($id)
    {
        $item_use = InvoiceEntry::where('item_id', $id)->get();
        if(count($item_use) > 0)
        {
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, Item is used in invoice. You can not delete this item.');
        }

        $item_use = BillEntry::where('item_id', $id)->get();
        if(count($item_use) > 0)
        {
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, Item is used in bill. You can not delete this item.');
        }

        $item = Item::find($id);

        if ($item->delete())
        {
            if(isset($item->image)){
                unlink($item->image);
            }

            return redirect()
                ->route('inventory')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Item deleted successfully!');
        }
        else
        {
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Data cannot be deleted.');
        }
    }
}
