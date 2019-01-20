<?php

namespace App\Modules\Bill\Http\Controllers;

use App\Models\Inventory\Item;
use App\Models\MoneyOut\BillFreeEntry;
use App\Models\MoneyOut\BillFreeReceiveEntry;
use Illuminate\Http\Request;
use App\Models\Inventory\Stock;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MoneyOut\FreeReceived;
use Auth;

class FreeReceivedController extends Controller
{
    public function index(){
        $bill_free_entry    = BillFreeEntry::leftjoin('bill_free_receive_entry','bill_free_receive_entry.bill_free_entry_id','bill_free_entry.id')
                                            ->selectRaw('bill_free_entry.product_id as product_id,
                                                            sum(bill_free_entry.receivable_quantity) as total_receivable, 
                                                            count(bill_free_entry.bill_id) as total_bill,
                                                            bill_free_receive_entry.id as bill_free_receive_entry_id
                                            ')
                                            ->groupBy('bill_free_entry.product_id')
                                            ->get();

        return view("bill::free_received.index",compact('bill_free_entry'));
    }

    public function create($id){
        $products           = Item::all();
        $bill_free_entry    = BillFreeEntry::join('bill','bill.id','bill_free_entry.bill_id')
                                            ->select('bill_free_entry.bill_id','bill.bill_date','bill.bill_number','bill.bill_date','bill_free_entry.receivable_quantity')
                                            ->where('bill_free_entry.product_id', $id)
                                            ->get();
        $product_id        = $id;

        return view("bill::free_received.create",compact('products','bill_free_entry', 'product_id'));
    }

    public function store(Request $request){

        for($i=0; $i < count($request->received_qty); $i++) {

            $bill_free_entry                            = new BillFreeEntry();

            $bill_free_entry->bill_id                   = $request->bill_id;
            $bill_free_entry->product_id                = $request->product_id;
            $bill_free_entry->total_quantity            = $request->total_qty[$i];
            $bill_free_entry->receivable_quantity       = $request->total_qty[$i] - $request->received_qty[$i];
            $bill_free_entry->save();
        }

        if($bill_free_entry->save()){
            for($j=0; $i < count($request->received_qty); $j++) {

                $stock                  = new Stock();
                $stock->total           = $request->total_qty[$j] - $request->received_qty[$j];
                $stock->date            = date("Y-m-d", strtotime($request->date));
                $stock->item_id         = $request->product_id;
                $stock->bill_id         = $request->bill_id;
                $stock->branch_id       = 1;
                $stock->created_by      = Auth::user()->id;
                $stock->updated_by      = Auth::user()->id;
                $stock->save();
            }
        }

        if( $stock->save()){

            for($k = 0; $k < count($request->received_qty); $k++){

                $item_update                      = Item::find($request->product_id);
                $item_update->total_purchases     = $item_update['total_purchases'] != null ?  $item_update['total_purchases'] : 0  + $request->received_qty[$k];
                $item_update->update();

            }

        }

        if($bill_free_entry->save()){
            return redirect()->route('free_received')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Free Item Received successfully');
        } else{
            return redirect()->route('free_received')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'not added! Something went wrong');
        }
    }

    public function history($id){
        $bill_free_received_entry = BillFreeReceiveEntry::join('bill_free_entry','bill_free_entry.id','bill_free_receive_entry.bill_free_entry_id')
                                                        ->join('bill','bill.id','bill_free_entry.bill_id')
                                                        ->select('bill.bill_number','bill_free_receive_entry.id',
                                                            'bill_free_receive_entry.date',
                                                            'bill_free_receive_entry.received_quantity'
                                                        )
                                                        ->where('bill_free_receive_entry.id', $id)
                                                        ->get();

        return view("bill::free_received.history",compact('bill_free_received_entry'));
    }

    public function historyEdit($id){
        $bill_free_received_entry = BillFreeReceiveEntry::join('bill_free_entry','bill_free_entry.id','bill_free_receive_entry.bill_free_entry_id')
                                                        ->join('bill','bill.id','bill_free_entry.bill_id')
                                                        ->select('bill.id as bill_id','bill.bill_number','bill_free_receive_entry.id',
                                                                    'bill_free_receive_entry.date',
                                                                    'bill_free_entry.product_id',
                                                                    'bill_free_entry.receivable_quantity',
                                                                    'bill_free_receive_entry.bill_free_entry_id',
                                                                    'bill_free_receive_entry.received_quantity'
                                                        )
                                                        ->where('bill_free_receive_entry.id', $id)
                                                        ->first();

        return view("bill::free_received.history-edit",compact('bill_free_received_entry'));
    }

    public function historyUpdate(Request $request, $id){
        $bill_free_receive_entry                            =   BillFreeReceiveEntry::find($id);

        $bill_free_receive_entry->bill_free_entry_id        =   $request->bill_free_entry_id ;
        $bill_free_receive_entry->date                      =   $request->date ;
        $bill_free_receive_entry->received_quantity         =   $request->received_quantity ;
        $bill_free_receive_entry->update();

        if($bill_free_receive_entry->update()){

            $stock                  = new Stock();
            $stock->total           = $request->received_quantity;
            $stock->date            = date("Y-m-d", strtotime($request->date));
            $stock->item_id         = $request->product_id;
            $stock->bill_id         = $request->bill_id;
            $stock->branch_id       = 1;
            $stock->created_by      = Auth::user()->id;
            $stock->updated_by      = Auth::user()->id;
            $stock->save();
        }

        if($stock->save()){

            $item_update   = Item::find($request->product_id);

            $item_update->total_purchases     = $item_update['total_purchases'] != null ?  $item_update['total_purchases'] : 0  + $request->quantity;

            $item_update->update();
        }

        if( $item_update->update()){
            return redirect()->route('free_received_history',$id)
                ->with('alert.status', 'success')
                ->with('alert.message', 'Free Received History update successfully');
        } else{
            return redirect()->route('free_received_history',$id)
                ->with('alert.status', 'danger')
                ->with('alert.message', 'not added! Something went wrong');
        }

    }

}
