<?php

namespace App\Modules\Bill\Http\Controllers;

use App\Models\Inventory\Stock;
use App\Models\MoneyOut\BillEntry;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Models\Inventory\Item;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReceiveUndeliveredItemController extends Controller
{
    public function create(){
        $company     = Contact::where('contact_category_id', 2)->get();
        return view("bill::receive_undelivered.create",compact('company'));
    }

    public function getItem($id){
        $items  = Item::leftjoin('bill_entry', 'bill_entry.item_id','item.id')
                        ->selectRaw('item.*, bill_entry.undelivered_quantity as quantity')
                        ->where('company_id',$id)
                        ->get();

        return Response::json($items);
    }


    public function getUndeliveredItem($id,$company_id){
        $items  = BillEntry::leftjoin('item', 'item.id', 'bill_entry.item_id')
                            ->leftjoin('bill','bill.id', 'bill_entry.bill_id')
                            ->leftjoin('contact','contact.id', 'bill.company_id')
                            ->selectRaw('item.*, bill_entry.undelivered_quantity as quantity, contact.display_name as company_name, bill_entry.bill_id as bill_id')
                            ->where('item.company_id',$company_id)
                            ->where('item.id',$id)
                            ->where('bill_entry.undelivered_quantity', '>', 0)
                            ->first();

        return Response::json($items);
    }



    public function update(Request $request){

        try {
            $stock = new Stock();

            $stock->total = $request->current_undelivered_quantity;
            $stock->date = $request->received_date;
            $stock->item_id = $request->item_id;
            $stock->bill_id = $request->bill_id;
            $stock->branch_id = 1;
            $stock->created_by = Auth::user()->id;
            $stock->updated_by = Auth::user()->id;

            $stock->save();

            if ($stock->save()) {
                $item_update = Item::find($request->item_id);

                $item_update->total_purchases = $request->received_quantity;

                $item_update->update();
            }

            if ($item_update->update()) {

                $bill_entry = BillEntry::where('bill_id', $request->bill_id)->where('item_id', $request->item_id)->get();

                for ($i = 0; $i < count($bill_entry); $i++) {

                    $bill_entry[$i]['undelivered_quantity'] = ($bill_entry[$i]['undelivered_quantity'] - $request->received_quantity );
                    $bill_entry[$i]['delivered_quantity'] = ($bill_entry[$i]['delivered_quantity'] + $request->received_quantity );
                    $bill_entry[$i]->save();
                }

            }

            return redirect()->route('receive_undelivered')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Received Undelivered Item successfully');

        } catch (exception $e) {
            return redirect()->route('receive_undelivered')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Something went wrong.');
        }

    }
}
