<?php

namespace App\Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact\Contact;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MoneyOut\Bill;
use App\Models\MoneyOut\BillEntry;
use App\Models\Moneyin\Invoice;
use App\Models\Moneyin\InvoiceEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Db;
use DateTime;

use App\Models\Branch\Branch;

use App\Models\Contact\ContactCategory;
use App\Models\ManualJournal\JournalEntry;
use App\Models\AccountChart\Account;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Modules\Report\Http\Response\ContactReport;

class ContactWiseReportController extends Controller
{
    public function index(Request $request)
    {
        if (($request->from_date) != null && ($request->to_date) != null) {
            $start = date('d-m-Y', strtotime($request->from_date));
            $end = date('d-m-Y', strtotime($request->to_date));
            $start_date = $request->from_date;
            $end_date = $request->to_date;
            //dd($start_date);
        } else {
            $current_time = Carbon::now()->toDayDateTimeString();
            $start = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
            $end = (new DateTime($current_time))->modify('+0 day')->format('d-m-Y');

            $start_date = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
            $end_date = (new DateTime($current_time))->modify('+0 day')->format('Y-m-d');
        }

        $category = ContactCategory::all();

        $data = array();
        //$contact_id_array = Contact::select('id','display_name')->groupBy('contact_category_id')->get();
        $contact_id_array = Contact::select('id','display_name','contact_category_id')->get();


       // $ymd = DateTime::createFromFormat('m-d-Y', '10-16-2003')->format('Y-m-d');


        $row_count = Contact::count();
        for ($i = 0; $i < $row_count; $i++) {

            $total_sales = Invoice::whereBetween(DB::raw("date_format(str_to_date(invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"),[$start_date,$end_date])
            ->where('customer_id', $contact_id_array[$i]['id'])
                ->groupBy('customer_id')
                ->sum('total_amount');

            $total_purchase = Bill::whereBetween('bill_date', [$start_date, $end_date])
                ->where('vendor_id', $contact_id_array[$i]['id'])
                ->groupBy('vendor_id')
                ->sum('amount');
            //dd($total_purchase);


            $data[] = array(                
                'id' => $contact_id_array[$i]['id'],
                'category'=> $contact_id_array[$i]['contact_category_id'],
                'name'=>$contact_id_array[$i]['display_name'],
                'total_sales' => $total_sales,
                'total_purchase' => $total_purchase
            );
        }

        $OrganizationProfile = OrganizationProfile::find(1);
        return view('report::ContactWiseItem.index', compact('start', 'end', 'data','category','OrganizationProfile'));
    }

    public function details(Request $request, $id)
    {
        if (($request->from_date) != null && ($request->to_date) != null) {
            $start = date('d-m-Y', strtotime($request->from_date));
            $end = date('d-m-Y', strtotime($request->to_date));
            $start_date = $request->from_date;
            $end_date = $request->to_date;
            //dd($start_date);
        } else {
            $current_time = Carbon::now()->toDayDateTimeString();
            $start = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
            $end = (new DateTime($current_time))->modify('+0 day')->format('d-m-Y');


            $start_date = (new DateTime($current_time))->modify('-30 day')->format('Y-m-d');
            $end_date = (new DateTime($current_time))->modify('+0 day')->format('Y-m-d');
        }
        $invoices_data = InvoiceEntry::whereBetween(DB::raw("date_format(str_to_date(invoices.invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"), [$start_date, $end_date])
            ->join('invoices', 'invoices.id', 'invoice_entries.invoice_id')
            ->join('item', 'item.id', 'invoice_entries.item_id')
            ->where('invoices.customer_id', $id)
            ->selectRaw(
                '
                invoices.invoice_date as date, 
                CONCAT("INV-",invoices.invoice_number) as transaction_number,
                item.item_name as item_name, 
                invoice_entries.quantity as sales_quantity,
                null as purchase_quantity,
                invoice_entries.rate as rate,
                invoice_entries.amount as amount')
            ->get()
            ->toArray();


        $bill_data = BillEntry::whereBetween('bill.bill_date', [$start_date, $end_date])
            ->join('bill', 'bill_entry.bill_id', 'bill.id')
            ->join('item', 'item.id', 'bill_entry.item_id')
            ->where('bill.vendor_id', $id)
            ->selectRaw('
            bill.bill_date as date, 
            CONCAT("BILL-",bill.bill_number) as transaction_number,
            item.item_name as item_name, 
            null as sales_quantity,
            bill_entry.quantity as purchase_quantity,
            bill_entry.rate as rate,
            bill_entry.amount as amount')
            ->get()
            ->toArray();

        //dd($bill_data);

        $data = array_merge($invoices_data, $bill_data);
        $OrganizationProfile = OrganizationProfile::find(1);
        $name= Contact::find($id)->first_name;
        // dd($name);

        return view('report::ContactWiseItem.details', compact('id', 'start', 'end', 'data','OrganizationProfile','name'));
    }

}
