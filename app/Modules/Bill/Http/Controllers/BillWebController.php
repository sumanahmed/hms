<?php

namespace App\Modules\Bill\Http\Controllers;
use App\Lib\sortBydate;
use App\Models\AccountChart\Account;
use App\Models\Branch\Branch;
use App\Models\Flightnew\Confirmation;
use App\Models\Inventory\Item;
use App\Models\Inventory\SpecialOffer;
use App\Models\Inventory\Stock;
use App\Models\Manpower\Manpower_service;
use App\Models\Moneyin\InvoiceEntry;
use App\Models\MoneyOut\BillFreeReceiveEntry;
use App\Models\Recruit\Recruitorder;
use App\Modules\Bill\Http\Response\Payment;
use Dompdf\Exception;
use Illuminate\Support\Facades\App;
use Validator;
use App\Models\Visa\Ticket\Order\Order;
use App\Models\Visa\Visa;
use Illuminate\Http\Request;
use App\Models\MoneyOut\BillFreeEntry;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Contact\Contact;
use App\Models\ManualJournal\JournalEntry;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\MoneyOut\Bill;
use App\Models\MoneyOut\BillEntry;
use App\Models\MoneyOut\PaymentMade;
use App\Models\MoneyOut\PaymentMadeEntry;
use Response;

class BillWebController extends Controller
{
    public function index()
    {

        /*$auth_id = Auth::id();
        $branch_id = session('branch_id');
        $branchs = Branch::orderBy('id','asc')->get();
        $sort = new sortBydate();
        $condition = "YEAR(str_to_date(bill_date,'%Y-%m-%d')) = YEAR(CURDATE()) AND MONTH(str_to_date(bill_date,'%Y-%m-%d')) = MONTH(CURDATE())";
        $bills = [];
        $date = "bill_date";
        if($branch_id==1)
        {
            if($request->due){
                $bills = Bill::where('due_amount','!=',0)->get()->toArray();

            }
            else
            {
                $bills = Bill::whereRaw($condition)->get()->toArray();

            }
           try{
               $bills = $sort->get('\App\Models\MoneyOut\Bill', $date, 'Y-m-d', $bills);
               return view('bill::bill.index', compact('bills', 'branchs'));
           }catch (\Exception $exception){
               $bills = collect($bills);
               return view('bill::bill.index', compact('bills', 'branchs'));
           }

        }
        else
        {
            $bills = Bill::whereRaw($condition)
                           ->join('users','users.id','=','bill.created_by')
                           ->where('users.branch_id',$branch_id)
                           ->get()
                           ->toArray();
            $date = "bill_date";
            try{
                $bills = $sort->get('\App\Models\MoneyOut\Bill', $date, 'Y-m-d', $bills);


                return view('bill::bill.index', compact('bills', 'branchs'));
            }catch (\Exception $exception){

                return view('bill::bill.index', compact('bills', 'branchs'));
            }

        }*/
        $bills = Bill::all();

        return view('bill::bill.index', compact('bills'));
    }

    public function search(Request $request)
    {
        $branchs = Branch::orderBy('id','asc')->get();
        $branch_id =  $request->branch_id;
        if(session('branch_id')==1)
        {
            $branch_id =  $request->branch_id?$request->branch_id:session('branch_id');
        }
        else
        {
            $branch_id = session('branch_id');
        }
        $from_date =  date('Y-m-d',strtotime($request->from_date));
        $to_date =  date('Y-m-d',strtotime($request->to_date));
        $condition = "str_to_date(bill_date, '%Y-%m-%d') between '$from_date' and '$to_date'";
        $bills = [];
        if($branch_id==1){
            $bills = Bill::whereRaw($condition)->select(DB::raw('bill.*'))->get()->toArray();

        }else{
            $bills = Bill::whereRaw($condition)->select(DB::raw('bill.*'))->join('users','users.id','=','bill.created_by')->where('branch_id',$branch_id)->get()->toArray();

        }
        $date="bill_date";
        $sort= new sortBydate();
        try{
            $bills= $sort->get('\App\Models\MoneyOut\Bill',$date,'Y-m-d',$bills);
            return view('bill::bill.index', compact('bills','branchs','branch_id','from_date','to_date'));
        }catch (\Exception $exception){
            return view('bill::bill.index', compact('bills','branchs','branch_id','from_date','to_date'));
        }
    }

    public function create()
    {

        $bills = Bill::all();

        if(count($bills)>0){
            $bill = Bill::orderBy('created_at', 'desc')->first();
            $bill_number = $bill['bill_number'];
            $bill_number = $bill_number + 1;
        }else{
            $bill_number = 1;
        }

        $bill_number = str_pad($bill_number, 6, '0', STR_PAD_LEFT);
        $company     = Contact::where('contact_category_id', 2)->get();
        $accounts    = Account::all();
        $products    = Item::all();

        return view('bill::bill.create', compact('bill_number', 'company', 'accounts', 'products'));
    }

    public function ajaxProduct($id){

        $products           = Item::select('id','item_name','curtoon_size','item_purchase_rate')->where('company_id',$id)->get();
        $unload_account     = Account::whereRaw('account_name LIKE "%unload%" ')->where('contact_id', $id)->first();
        $purchase_account   = Account::whereRaw('account_name LIKE "%purchase%" ')->where('contact_id', $id)->first();

        return Response::json(array(
            'products'              =>  $products,
            'unload_account'        =>  $unload_account,
            'purchase_account'      =>  $purchase_account,
        ));
    }

    public function ajaxFreeItem($id, $quantity, $bill_date){

        $item        = SpecialOffer::join('item','item.id','special_offers.free_sku_id')
                                    ->select('special_offers.id','special_offers.sku_qty','special_offers.free_sku_qty','special_offers.free_sku_id','item.item_name')
                                    ->where('special_offers.sku_id',$id)
                                    ->where('special_offers.sku_qty','<=',$quantity)
                                    ->where('special_offers.from_date', '<=', $bill_date)
                                    ->where('special_offers.to_date', '>=', $bill_date)
                                    ->first();

        $total_qty   = ($quantity / $item['sku_qty']) * $item['free_sku_qty'] ;

        return Response::json(array(
            'total_qty'         =>  $total_qty,
            'special_offer_id'  =>  $item['id'],
            'free_sku_id'       =>  $item['free_sku_id'],
            'item_name'         =>  $item['item_name'],
        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bill_number'    => 'required',
            'bill_date'      => 'required',
            'due_date'       => 'required',
            'item_id.*'      => 'required',
            'quantity.*'     => 'required',
            'rate.*'         => 'required',
            'company_id'     => 'required',
            'company_invoice'=> 'required',
        ]);

        $bill_number    =   trim($request->bill_number, "PINV-");

        try{
            $bill = new Bill;

            $bill->bill_number      = $bill_number;
            $bill->amount           = $request->total_amount;
            $bill->due_amount       = $request->due_amount;
            $bill->unload_payment   = $request->unload_payment;
            $bill->bill_date        = date("Y-m-d", strtotime($request->bill_date));
            $bill->due_date         = date("Y-m-d", strtotime($request->due_date));
            $bill->item_rates       = 1;
            $bill->note             = $request->note;
            $bill->total_tax        = 0;
            $bill->company_id       = $request->company_id;
            $bill->company_invoice  = $request->company_invoice;

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $directory = 'uploads/images/bill/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;
                $bill->image = $imageUrl;
            }

            $bill->created_by       = Auth::user()->id;
            $bill->updated_by       = Auth::user()->id;

            if($bill->save())
            {
                /*Bill Entry*/
                    $arr = [];
                    for($i=0; $i<count($request->item_id); $i++){

                        $bill_entry                             =   new BillEntry();

                        $bill_entry->bill_id                    =   $bill->id;
                        $bill_entry->item_id                    =   $request->item_id[$i];
                        $bill_entry->rate                       =   $request->rate[$i];
                        $bill_entry->tax_id                     =   1;
                        $bill_entry->curtoon_size               =   $request->curtoon_size[$i];
                        $bill_entry->quantity                   =   $request->quantity[$i];
                        $bill_entry->undelivered_quantity       =   $request->undelivered_quantity[$i];
                        $bill_entry->delivered_quantity         =   $request->delivered_quantity[$i];
                        $bill_entry->amount                     =   ($request->rate[$i] * $request->quantity[$i]);
                        $bill_entry->created_by                 =   Auth::user()->id;
                        $bill_entry->updated_by                 =   Auth::user()->id;

                        $bill_entry->save();

                        $arr[$i]   = $bill_entry->id;
                    }
                /*Bill Entry Ends*/

                /*Journal Entry*/
                    if($bill_entry->save()) {
                        for ($j = 0; $j < count($request->account_id); $j++) {

                            $journal_entry                  = new JournalEntry();

                            $journal_entry->bill_id         = $bill->id;
                            $journal_entry->debit_credit    = $request->debit[$j] ? 1 : 0;
                            $journal_entry->amount          = $request->debit[$j] ? $request->debit[$j] : $request->credit[$j];
                            $journal_entry->account_name_id = $request->account_id[$j];
                            $journal_entry->jurnal_type     = "bill";
                            $journal_entry->assign_date     = date("Y-m-d", strtotime($request->bill_date));

                            $journal_entry->created_by      = Auth::user()->id;
                            $journal_entry->updated_by      = Auth::user()->id;

                            $journal_entry->save();

                        }
                    }
                /*Journal Entry Ends*/

                /*Stock Update*/
                    if($journal_entry->save()){

                        for ($k = 0; $k < count($request->item_id); $k++) {

                            $stock                  = new Stock();
                            $stock->total           = $request->delivered_quantity[$k];
                            $stock->date            = date("Y-m-d", strtotime($request->bill_date));
                            $stock->item_id         = $request->item_id[$k];
                            $stock->bill_id         = $bill->id;
                            $stock->branch_id       = 1;

                            $stock->created_by      = Auth::user()->id;
                            $stock->updated_by      = Auth::user()->id;

                            $stock->save();
                        }

                    }
                /*Stock Update Ends*/

                /*Item Purchase rate and Total Purchase Update*/
                    if($stock->save()){

                        for ($x = 0; $x < count($request->item_id); $x++) {

                            $item_update   = Item::find($request->item_id[$x]);

                            $item_update->item_purchase_rate  = $request->rate[$x];
                            $item_update->total_purchases     = $item_update['total_purchases'] != null ?  $item_update['total_purchases'] : 0  + $request->quantity[$x];

                            $item_update->update();
                        }
                    }
                /*Item Purchase rate and Total Purchase Update Ends*/

                /*Bill Free Entry*/
                    if($item_update->update()){

                        for ($p = 0; $p < count($request->product_id); $p++) {

                            $bill_free_index = $request->bill_entry_index[$p];

                            $bill_free_entry                            = new BillFreeEntry();

                            $bill_free_entry->bill_id                   = $bill->id;


                            if(isset($arr[$bill_free_index])) {
                                $bill_free_entry->bill_entry_id = $arr[$bill_free_index];
                            }
                            $bill_free_entry->special_offer_id          = $request->special_offer_id[$p];
                            $bill_free_entry->product_id	            = $request->product_id[$p];
                            $bill_free_entry->total_quantity            = $request->total_qty[$p];
                            $bill_free_entry->receivable_quantity       = $request->total_qty[$p] - $request->received_qty[$p];
                            $bill_free_entry->created_by                = Auth::user()->id;
                            $bill_free_entry->updated_by                = Auth::user()->id;

                            $bill_free_entry->save();
                        }
                    }
                /*Bill Free Entry Ends*/

                /*Bill Free Receive Entry*/
                    if($bill_free_entry->save()){

                        for ($q = 0; $q < count($request->product_id); $q++) {

                            $bill_free_receive_entry                        = new BillFreeReceiveEntry();

                            $bill_free_receive_entry->bill_free_entry_id    = $bill_free_entry->id;
                            $bill_free_receive_entry->date                  = date("Y-m-d", strtotime($request->bill_date));
                            $bill_free_receive_entry->received_quantity     = $request->received_qty[$q];
                            $bill_free_receive_entry->created_by            = Auth::user()->id;
                            $bill_free_receive_entry->updated_by            = Auth::user()->id;

                            $bill_free_receive_entry->save();
                        }
                    }
                /*Bill Free Entry Ends*/

                /*Stock Update For Bill Free Entry*/
                    if($bill_free_receive_entry->save()){

                        for ($r = 0; $r < count($request->product_id); $r++) {

                            $stock                  = new Stock();
                            $stock->total           = $request->received_qty[$r];
                            $stock->date            = date("Y-m-d", strtotime($request->bill_date));
                            $stock->item_id         = $request->product_id[$r];
                            $stock->bill_id         = $bill->id;
                            $stock->branch_id       = 1;
                            $stock->created_by      = Auth::user()->id;
                            $stock->updated_by      = Auth::user()->id;
                            $stock->save();
                        }
                    }
                /*Stock Update For Bill Free Entry Ends*/

                /*Item Update For Bill Free Entry*/
                    if($stock->save()){
                        for ($s = 0; $s < count($request->product_id); $s++) {
                            $item = Item::find($request->product_id[$s]);
                            $item->total_purchases = $item->total_purchases + $request->received_qty[$s];
                            $item->update();
                        }
                    }
                /*Item Update For Bill Free Entry Ends*/

                if($item->update()){
                    return redirect()->route('purchase_invoice')
                                        ->with('alert.status', 'success')
                                        ->with('alert.message', 'Purchase Invoice save successfully');
                } else{
                    return redirect()->route('purchase_invoice')
                                    ->with('alert.status', 'danger')
                                    ->with('alert.message', 'not added! Something went wrong');
                }
            }

            throw new \Exception("bill creation fail");

        }catch(\Exception $ex){

            $msg = $ex->getMessage();
            return redirect()->route('purchase_invoice')
                            ->with('alert.status', 'danger')
                            ->with('alert.message', "Fail : $msg");
        }
    }

    public function show($id)
    {
        $bill = Bill::find($id);
        $bills = Bill::orderBy('id','DESC')->take(10)->get()->toArray();
        $date="bill_date";
        $sort= new sortBydate();
        $bills= $sort->get('\App\Models\MoneyOut\Bill',$date,'Y-m-d',$bills);
        $bill_entries = BillEntry::where('bill_id',$id)->get();
        $payment_made_entries = PaymentMadeEntry::where('bill_id', $id)->get();
        $OrganizationProfile = OrganizationProfile::find(1);

        $sub_total = 0;
        foreach ($bill_entries as $bill_entry)
        {
            $sub_total = $sub_total + $bill_entry->amount;
        }
        $confirmation=Confirmation::where('bill_id',$id)->first();
        if ($confirmation) {
            $bill->e_ticket_number=$confirmation->e_ticket_number;
            $order=Recruitorder::where('id',$confirmation->pax_id)->first();
            $bill->passportNumber=$order->passportNumber;
            $bill->passenger_name=$order->passenger_name;
        }
        return view('bill::bill.show', compact('OrganizationProfile','bill', 'bills', 'bill_entries','sub_total', 'payment_made_entries'));
    }

    public function showupload(Request $request,$id=null){
        $bill = Bill::find($id);
        $validator = Validator::make($request->all(), [
            'file1' => 'required|max:10240',

        ]);


        if($validator->fails()){
            return response("file size not allowed ");
        }
        if($request->hasFile('file1')) {
            $file = $request->file('file1');

            if ($bill->file_url) {
                $delete_path = public_path($bill->file_url);
                if(file_exists($delete_path)){
                    $delete = unlink($delete_path);
                }

            }

            $file_name = $file->getClientOriginalName();
            $without_extention = substr($bill, 0, strrpos($file_name, "."));
            $file_extention = $file->getClientOriginalExtension();
            $num = rand(1, 500);
            $new_file_name = "bill-".$bill->bill_number.'.'.$file_extention;

            $success = $file->move('uploads/bill', $new_file_name);

            if ($success) {
                $bill->file_url = 'uploads/bill/' . $new_file_name;
                //$Bank->file_name = $new_file_name;

                $bill->save();
                return response("success");
            }else{
                return response("success");
            }
        }else{
            return response("file not found");
        }

    }

    public function edit($id){
        $bill           = Bill::find($id);
        $bill_entrys    = BillEntry::where('bill_id', $id)->get();
        $items          = Item::all();
        $company        = Contact::where('contact_category_id', 2)->get();
        $accounts       = Account::all();
        $journal_entrys = JournalEntry::select('debit_credit','amount','account_name_id')->where('bill_id', $id)->get();
        $products       = Item::all();

        $free_entrys    = BillFreeEntry::leftjoin('item','item.id','bill_free_entry.product_id')
                                        ->select('item.item_name','bill_free_entry.id','bill_free_entry.product_id','bill_free_entry.total_quantity','bill_free_entry.receivable_quantity')
                                        ->where('bill_free_entry.bill_id', $id)
                                        ->get();

        return view('bill::bill.edit', compact('bill', 'bill_entrys', 'items', 'company', 'accounts','journal_entrys','products','free_entrys'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'bill_number'    => 'required',
            'bill_date'      => 'required',
            'due_date'       => 'required',
            'item_id.*'      => 'required',
            'quantity.*'     => 'required',
            'rate.*'         => 'required',
            'company_id'     => 'required',
            'company_invoice'=> 'required',
        ]);

        $bill_number    =   trim($request->bill_number, "PINV-");

        try{
            $bill = Bill::find($id);

            $bill->bill_number      = $bill_number;
            $bill->amount           = $request->total_amount;
            $bill->due_amount       = $request->due_amount;
            $bill->unload_payment   = $request->unload_payment;
            $bill->bill_date        = date("Y-m-d", strtotime($request->bill_date));
            $bill->due_date         = date("Y-m-d", strtotime($request->due_date));
            $bill->item_rates       = 1;
            $bill->note             = $request->note;
            $bill->total_tax        = 0;
            $bill->company_id       = $request->company_id;
            $bill->company_invoice  = $request->company_invoice;

            if($request->hasFile('image')){

                if($bill->image != null){
                    unlink($bill->image);
                }

                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $directory = 'uploads/images/bill/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;
                $bill->image = $imageUrl;
            }

            $bill->created_by       = Auth::user()->id;
            $bill->updated_by       = Auth::user()->id;


            if($bill->update())
            {
                /*Bill Entry*/
                $total_item = count($request->item_id);

                if($total_item > 0) {

                    $delete_bill_entry = BillEntry::where('bill_id', $id)->delete();

                    for ($i = 0; $i < $total_item; $i++) {

                        $bill_entry = new BillEntry();

                        $bill_entry->bill_id = $bill->id;
                        $bill_entry->item_id = $request->item_id[$i];
                        $bill_entry->rate = $request->rate[$i];
                        $bill_entry->tax_id = 1;
                        $bill_entry->curtoon_size = $request->curtoon_size[$i];
                        $bill_entry->quantity = $request->quantity[$i];
                        $bill_entry->undelivered_quantity = $request->undelivered_quantity[$i];
                        $bill_entry->delivered_quantity = $request->delivered_quantity[$i];
                        $bill_entry->amount = ($request->rate[$i] * $request->quantity[$i]);
                        $bill_entry->created_by = Auth::user()->id;
                        $bill_entry->updated_by = Auth::user()->id;

                        $bill_entry->save();
                    }

                    /*Bill Entry Ends*/

                    /*Journal Entry*/
                        if($bill_entry->save()) {

                            $total_account  =  count($request->account_id);
                            if($total_account > 0) {

                                $delete_journal_entry = JournalEntry::where('bill_id', $id)->delete();

                                for ($j = 0; $j < count($request->account_id); $j++) {

                                    $journal_entry = new JournalEntry();

                                    $journal_entry->bill_id = $bill->id;
                                    $journal_entry->debit_credit = $request->debit[$j] ? 1 : 0;
                                    $journal_entry->amount = $request->debit[$j] ? $request->debit[$j] : $request->credit[$j];
                                    $journal_entry->account_name_id = $request->account_id[$j];
                                    $journal_entry->jurnal_type = "bill";
                                    $journal_entry->assign_date = date("Y-m-d", strtotime($request->bill_date));

                                    $journal_entry->created_by = Auth::user()->id;
                                    $journal_entry->updated_by = Auth::user()->id;

                                    $journal_entry->save();
                                }

                                /*Stock Update*/
                                    if($journal_entry->save()){

                                        for ($k = 0; $k < count($request->item_id); $k++) {

                                            $stock                  = new Stock();
                                            $stock->total           = $request->delivered_quantity[$k];
                                            $stock->date            = date("Y-m-d", strtotime($request->bill_date));
                                            $stock->item_id         = $request->item_id[$k];
                                            $stock->bill_id         = $bill->id;
                                            $stock->branch_id       = 1;

                                            $stock->created_by      = Auth::user()->id;
                                            $stock->updated_by      = Auth::user()->id;

                                            $stock->save();
                                        }

                                        /*Item Purchase rate and Total Purchase Update*/
                                            if($stock->save()){

                                                for ($x = 0; $x < count($request->item_id); $x++) {

                                                    $item_update   = Item::find($request->item_id[$x]);

                                                    $item_update->item_purchase_rate  = $request->rate[$x];
                                                    $item_update->total_purchases     = $item_update['total_purchases'] != null ?  $item_update['total_purchases'] : 0  + $request->quantity[$x];

                                                    $item_update->update();
                                                }

                                                /*Bill Free Entry Table update*/

                                                    if($item_update->update()){

                                                        $bill_free_entry  = BillFreeEntry::select('id')->where('bill_id', $id)->first();

                                                        for ($p = 0; $p < count($request->product_id); $p++) {

                                                            $bill_free_entry                            = BillFreeEntry::find($bill_free_entry['id']);
                                                            $bill_free_entry->bill_id                   = $id;
                                                            $bill_free_entry->special_offer_id          = $request->special_offer_id[$p];
                                                            $bill_free_entry->product_id                = $request->product_id[$p];
                                                            $bill_free_entry->total_quantity            = $request->total_qty[$p];
                                                            $bill_free_entry->update();
                                                        }
                                                        if($bill_free_entry->update()){
                                                            return redirect()->route('purchase_invoice')
                                                                ->with('alert.status', 'success')
                                                                ->with('alert.message', 'Purchase Invoice update successfully');
                                                        } else{
                                                            return redirect()->route('purchase_invoice')
                                                                ->with('alert.status', 'danger')
                                                                ->with('alert.message', 'not added! Something went wrong');
                                                        }
                                                    }
                                                /*Bill Free Entry Table update Ends*/
                                            }
                                        /*Item Purchase rate and Total Purchase Update Ends*/

                                    }
                                /*Stock Update Ends*/
                            }
                        }
                    /*Journal Entry Ends*/
                }
            }
            throw new \Exception("bill creation fail");

        }catch(\Exception $ex){

            $msg = $ex->getMessage();
            return redirect()->route('purchase_invoice')
                ->with('alert.status', 'danger')
                ->with('alert.message', "Fail : $msg");
        }
    }

    public function markupdate($id)
    {
        DB::beginTransaction();
        $branch_id = session('branch_id');
        try{
            $bill = Bill::find($id);
            $bill->save = null;
            $bill->save();
            $datas= $bill->billEntries->toArray();
            $user_id = Auth::user()->id;
            $i = 0;
            $account_array = array_fill(1, 100, 0);
            foreach($datas as $data)
            {
                $amount = $data['quantity']*$data['rate'];
                $account_array[$data['account_id']] =  $account_array[$data['account_id']] + $amount;
                $i++;
            }
            //insert total amount as debit
            $journal_entry = new JournalEntry;
            $journal_entry->note            = $bill->note;
            $journal_entry->debit_credit    = 0;
            $journal_entry->amount          = $bill->amount;
            $journal_entry->account_name_id = 11;
            $journal_entry->jurnal_type     = "bill";
            $journal_entry->bill_id         =$id;
            $journal_entry->contact_id      = $bill->vendor_id;
            $journal_entry->created_by      = $user_id;
            $journal_entry->updated_by      = $user_id;
            $journal_entry->assign_date      = date('Y-m-d',strtotime($bill->bill_date));
            if($journal_entry->save())
            {
                     if($bill->total_tax>0)
                     {
                         $journal_entry = new JournalEntry;
                         $journal_entry->note            = $bill->note;
                         $journal_entry->debit_credit    = 1;
                         $journal_entry->amount          = $bill->total_tax;
                         $journal_entry->account_name_id = 9;
                         $journal_entry->jurnal_type     = "bill";
                         $journal_entry->bill_id         = $bill->id;
                         $journal_entry->contact_id      = $bill->vendor_id;
                         $journal_entry->created_by      = $user_id;
                         $journal_entry->updated_by      = $user_id;
                         $journal_entry->assign_date      = date('Y-m-d',strtotime($bill->bill_date));
                         $journal_entry->save();

                     }

                     $bill_entry = [];
                     for($j = 1; $j<count($account_array)-2; $j++)
                     {
                         if ($account_array[$j] != 0)
                         {
                             $bill_entry[] = [
                                 'note'              => $bill->note,
                                 'debit_credit'      => 1,
                                 'amount'            => $account_array[$j],
                                 'account_name_id'   => $j,
                                 'jurnal_type'       => 'bill',
                                 'bill_id'           => $bill->id,
                                 'contact_id'        => $bill->vendor_id,
                                 'created_by'        => $user_id,
                                 'updated_by'        => $user_id,
                                 'created_at'        => \Carbon\Carbon::now()->toDateTimeString(),
                                 'updated_at'        => \Carbon\Carbon::now()->toDateTimeString(),
                                 'assign_date'      => date('Y-m-d',strtotime($bill->bill_date)),
                             ];

                         }
                     }
                 }
                 else
                 {
                     throw new \Exception();
                 }


          if(DB::table('journal_entries')->insert($bill_entry))
            {


                foreach ($datas as $item)
                {
                    $items = Item::find($item['item_id']);
                    $items->total_purchases += $item['quantity'];
                    $items->save();


                }

                foreach ($datas as $item)
                {
                    $stock = new Stock;
                    $stock->total = $item['quantity'];
                    $stock->date =  $bill->bill_date;
                    $stock->item_category_id = Item::find($item['item_id'])->itemCategory->id;
                    $stock->item_id = $item['item_id'];
                    $stock->bill_id = $bill->id;
                    $stock->branch_id = $branch_id;
                    $stock->created_by = $user_id;
                    $stock->updated_by = $user_id;
                    $stock->save();

                }
                DB::commit();
                return back()
                           ->with('alert.status', 'success')
                                  ->with('alert.message', 'Journal added.');
            }
            else
            {
                throw new \Exception('Unable');
            }

        }
        catch(\Exception $exception)
        {
            DB::rollBack();
            return back()
                       ->with('alert.status', 'danger')
                             ->with('alert.message', 'Transaction fail');
        }


    }

    public function destroy($id)
    {
        DB::beginTransaction();

            $bill_entry = BillEntry::select('item_id','quantity')->where('bill_id', $id)->get();

            for($i = 0; $i < $bill_entry->count(); $i++){

                $item = Item::find($bill_entry[$i]['item_id']);
                $item->total_purchases = ($item->total_purchases - $bill_entry[$i]['quantity']);
                $item->update();
            }

            if($item->update()){

                $bill_free_entry = BillFreeEntry::select('product_id','total_quantity')->where('bill_id', $id)->get();

                for($j = 0; $j < $bill_free_entry->count(); $j++){
                    $item2 = Item::find($bill_free_entry[$j]['product_id']);
                    $item2->total_purchases = ($item2->total_purchases - $bill_free_entry[$j]['total_quantity']);
                    $item2->update();
                }

                if($item2->update()){

                    $bill = Bill::find($id);

                    if($bill->delete())
                    {
                        DB::commit();
                        return redirect()
                            ->route('purchase_invoice')
                            ->with('alert.status', 'danger')
                            ->with('alert.message', 'Purchase Invoice deleted successfully!!!');
                    }else{
                        DB::rollBack();
                        return redirect()
                            ->route('purchase_invoice')
                            ->with('alert.status', 'danger')
                            ->with('alert.message', 'Bill not deleted');
                    }
                }
            }
    }

    public function insertBillInJournalEntries($data, $total_amount, $total_tax, $bill_id)
    {
        $user_id = Auth::user()->id;
        $i = 0;


        $account_array = array_fill(1, 100, 0);
        foreach ($data['item_id'] as $item_id)
        {
            $amount = $data['quantity'][$i]*$data['rate'][$i];
            $account_array[$data['account_id'][$i]] =  $account_array[$data['account_id'][$i]] + $amount;
            $i++;
        }

        $journal_entry = new JournalEntry;
        $journal_entry->note            = $data['customer_note'];
        $journal_entry->debit_credit    = 0;
        $journal_entry->amount          = $total_amount;
        $journal_entry->account_name_id = 11;
        $journal_entry->jurnal_type     = "bill";
        $journal_entry->bill_id         = $bill_id;
        $journal_entry->contact_id      = $data['customer_id'];
        $journal_entry->created_by      = $user_id;
        $journal_entry->updated_by      = $user_id;
        $journal_entry->assign_date      = date('Y-m-d',strtotime($data['bill_date']));

        if($journal_entry->save())
        {

        }
        else
        {
            //delete all journal entry for this invoice...
            $bill = Bill::find($bill_id);
            $bill->delete();
            return false;
        }

        if($total_tax>0)
        {
            $journal_entry = new JournalEntry;
            $journal_entry->note            = $data['customer_note'];
            $journal_entry->debit_credit    = 1;
            $journal_entry->amount          = $total_tax;
            $journal_entry->account_name_id = 9;
            $journal_entry->jurnal_type     = "bill";
            $journal_entry->bill_id         = $bill_id;
            $journal_entry->contact_id      = $data['customer_id'];
            $journal_entry->created_by      = $user_id;
            $journal_entry->updated_by      = $user_id;
            $journal_entry->assign_date      = date('Y-m-d',strtotime($data['bill_date']));

            if($journal_entry->save())
            {

            }
            else
            {
                //delete all journal entry for this invoice...
                $bill = Bill::find($bill_id);
                $bill->delete();
                return false;
            }
        }

        $bill_entry = [];
        for($j = 1; $j<count($account_array)-2; $j++) {
            if ($account_array[$j] != 0)
            {
                $bill_entry[] = [
                    'note'              => $data['customer_note'],
                    'debit_credit'      => 1,
                    'amount'            => $account_array[$j],
                    'account_name_id'   => $j,
                    'jurnal_type'       => 'bill',
                    'bill_id'           => $bill_id,
                    'contact_id'        => $data['customer_id'],
                    'created_by'        => $user_id,
                    'updated_by'        => $user_id,
                    'created_at'        => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at'        => \Carbon\Carbon::now()->toDateTimeString(),
                    'assign_date'      => date('Y-m-d',strtotime($data['bill_date'])),
                ];

            }
        }

        if (DB::table('journal_entries')->insert($bill_entry))
        {
            return true;
        }
        else
        {
            //delete all journal entry for this invoice...
            $bill = Bill::find($bill_id);
            $bill->delete();
            return false;
        }

        return false;
    }

    public function updateBillInJournalEntries($data, $total_amount, $total_tax, $bill_id)
    {

        $bill_entries_delete = Bill::find($bill_id)->journalEntries();

        //Update Time 

        $created = Bill::find($bill_id);

        $created_by = $created->created_by;
        $created_at = $created->created_at->toDateTimeString();
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();

        if($bill_entries_delete->delete())
        {

        }

        $user_id = Auth::user()->id;
        $i = 0;
        $account_array = array_fill(1, 100, 0);
        foreach($data['item_id'] as $account)
        {
            $amount = $data['quantity'][$i]*$data['rate'][$i];
            $account_array[$data['account_id'][$i]] =  $account_array[$data['account_id'][$i]] + $amount;
            $i++;
        }

        //insert total amount as debit
        $journal_entry = new JournalEntry;
        $journal_entry->note            = $data['customer_note'];
        $journal_entry->debit_credit    = 0;
        $journal_entry->amount          = $total_amount;
        $journal_entry->account_name_id = 11;
        $journal_entry->jurnal_type     = "bill";
        $journal_entry->bill_id         = $bill_id;
        $journal_entry->contact_id      = $data['customer_id'];
        $journal_entry->created_by      = $created_by;
        $journal_entry->updated_by      = $user_id;
        $journal_entry->created_at      = $created_at;
        $journal_entry->updated_at      = $updated_at;
        $journal_entry->assign_date     = date('Y-m-d',strtotime($data['bill_date']));

        if($journal_entry->save())
        {

        }
        else
        {
            //delete all journal entry for this invoice...
        }

        //insert tax total as debit
        if($total_tax>0)
        {
            $journal_entry = new JournalEntry;
            $journal_entry->note            = $data['customer_note'];
            $journal_entry->debit_credit    = 1;
            $journal_entry->amount          = $total_tax;
            $journal_entry->account_name_id = 9;
            $journal_entry->jurnal_type     = "bill";
            $journal_entry->bill_id         = $bill_id;
            $journal_entry->contact_id      = $data['customer_id'];
            $journal_entry->created_by      = $created_by;
            $journal_entry->updated_by      = $user_id;
            $journal_entry->created_at      = $created_at;
            $journal_entry->updated_at      = $updated_at;
            $journal_entry->assign_date     = date('Y-m-d',strtotime($data['bill_date']));
            if($journal_entry->save())
            {

            }
            else
            {
                //delete all journal entry for this invoice...
                $bill = Bill::find($bill_id);
                $bill->delete();
                return false;
            }
        }

        //return $account_array;

        $bill_entry = [];
        for($j = 1; $j<count($account_array)-2; $j++) {
            if ($account_array[$j] != 0)
            {
                $bill_entry[] = [
                    'note'              => $data['customer_note'],
                    'debit_credit'      => 1,
                    'amount'            => $account_array[$j],
                    'account_name_id'   => $j,
                    'jurnal_type'       => 'bill',
                    'bill_id'           => $bill_id,
                    'contact_id'        => $data['customer_id'],
                    'created_by'        => $created_by,
                    'updated_by'        => $user_id,
                    'created_at'        => $created_at,
                    'updated_at'        => $updated_at,
                    'assign_date'       => date('Y-m-d',strtotime($data['bill_date'])),
                ];

            }
        }

        if (DB::table('journal_entries')->insert($bill_entry))
        {
            return "successfull...";
        }
        else
        {
            //delete all journal entry for this invoice...
        }

        return "error";
    }

    public function useExcessPayment(Request $request)
    {
        $data = $request->all();
        //return $data;
        $user_id = Auth::user()->id;
        $helper = new \App\Lib\Helpers;
        $i = 0;
        foreach ($data['excess_payment_amount'] as $excess_payment_amount)
        {
            if($excess_payment_amount && $excess_payment_amount > 0)
            {
                $helper->updatePaymentMadeEntryAfterExcessAmountUse($data['bill_id'], $data['payment_made_id'][$i], $excess_payment_amount, $user_id);

                $payment_made = PaymentMade::find($data['payment_made_id'][$i]);
                $payment_made->excess_amount = ($payment_made['excess_amount'] - $excess_payment_amount);
                $payment_made->update();

                $bill = Bill::find($data['bill_id']);
                $bill->due_amount = $bill['due_amount'] - $excess_payment_amount;
                $bill->update();
            }
            $i++;
        }


        $i = 0;
        foreach ($data['excess_payment_amount'] as $excess_payment_amount)
        {
            if($excess_payment_amount)
            {
                $helper->addOrUpdateJournalEntryAfterUsingExcessAmountInBill($data['bill_id'], $data['payment_made_id'][$i], $excess_payment_amount, $user_id);
            }
            $i++;
        }

        return redirect()
            ->route('bill_show', ['id' => $data['bill_id']])
            ->with('alert.status', 'success')
            ->with('alert.message', 'Excess notes used successfully!');
    }
}
