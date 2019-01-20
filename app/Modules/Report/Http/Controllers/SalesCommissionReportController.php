<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Contact\Agent;
use App\Models\Contact\Contact;
use App\Models\ManualJournal\JournalEntry;
use App\Models\Moneyin\Invoice;
use App\Models\OrganizationProfile\OrganizationProfile;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesCommissionReportController extends Controller
{
    
    public function index()
    {
        $OrganizationProfile = OrganizationProfile::find(1);
        $current_time = Carbon::now()->toDayDateTimeString();

        $start = (new DateTime($current_time))->modify('-30 day')->format('d-m-Y');
        $end = (new DateTime($current_time))->modify('+0 day')->format('d-m-Y');
        $begin_time = (new DateTime($current_time))->modify('-999999 day')->format('d-m-Y');

        $journal = Invoice::groupBy('agents_id')
                        ->whereNotNull('agents_id')
                        ->where(DB::raw("date_format(str_to_date(invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"), '<=', DB::raw("date_format(str_to_date('$end', '%d-%m-%Y'), '%Y-%m-%d')"))
                        ->join('contact', 'contact.id', 'invoices.agents_id')
                        ->selectRaw('agentcommissionAmount ,commission_type ,sum(total_amount) as sum, sum(CASE WHEN commission_type = "1" THEN (total_amount*agentcommissionAmount/100) WHEN commission_type = "2" THEN agentcommissionAmount ELSE 0 END) as payable, count(invoices.id) as totalinvoice,agents_id,display_name as agent_name,sum(total_amount-due_amount) as receivable ')
                        ->get();

        return view('report::salesbyagent',compact('end','start','OrganizationProfile','journal'));
    }


    public function details($id,$start,$end)
    {

        $OrganizationProfile = OrganizationProfile::find(1);
        $start = date('Y-m-d 00:00:00',strtotime($start." " ."00:00:00"));
        $start_invoice_date = date('d-m-Y',strtotime($start));
        $end = date('Y-m-d 23:59:00',strtotime($end." " ."23:59:00"));

        $ag= Contact::find($id);
        $opening_balance_invoices = Invoice::where(DB::raw("date_format(str_to_date(invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"), '<', DB::raw("date_format(str_to_date('$start_invoice_date', '%d-%m-%Y'), '%Y-%m-%d')"))->where('agents_id',$id)->selectRaw("SUM(total_amount) as invoice_total_amount, SUM(due_amount) as invoice_due_amount")->get();
        $opening_balance_debit = JournalEntry::where('assign_date', '<', $start)->where('jurnal_type','sales_commission')->where('account_name_id',11)->where('agent_id',$id)->where('debit_credit',0)->sum('amount');
        $opening_balance_credit = JournalEntry::where('assign_date', '<', $start)->where('jurnal_type','sales_commission')->where('account_name_id',3)->where('agent_id',$id)->where('debit_credit',0)->sum('amount');
        $journal = JournalEntry::whereBetween('assign_date',array($start,$end))->where('jurnal_type','sales_commission')->where('agent_id',$id)->where('debit_credit',0)->get()->sortBy('assign_date');
        
        return view('report::single_agent_commission',compact('end','start','OrganizationProfile','journal','id','ag', 'opening_balance_debit', 'opening_balance_credit', 'opening_balance_invoices'));
    }


    public function detailsbydate(Request $request)
    {

        $OrganizationProfile = OrganizationProfile::find(1);
        $start = date('Y-m-d 00:00:00',strtotime($request->start." " ."00:00:00"));
        $start_invoice_date = date('d-m-Y',strtotime($request->start));
        $end = date('Y-m-d 00:00:00',strtotime($request->end." " ."23:59:00"));

        $id = $request->id;

        $ag= Contact::find($id);
        $opening_balance_invoices = Invoice::where(DB::raw("date_format(str_to_date(invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"), '<', DB::raw("date_format(str_to_date('$start_invoice_date', '%d-%m-%Y'), '%Y-%m-%d')"))->where('agents_id',$id)->selectRaw("SUM(total_amount) as invoice_total_amount, SUM(due_amount) as invoice_due_amount")->get();
        $opening_balance_debit = JournalEntry::where('assign_date', '<', $start)->where('jurnal_type','sales_commission')->where('account_name_id',11)->where('agent_id',$id)->where('debit_credit',0)->sum('amount');
        $opening_balance_credit = JournalEntry::where('assign_date', '<', $start)->where('jurnal_type','sales_commission')->where('account_name_id',3)->where('agent_id',$id)->where('debit_credit',0)->sum('amount');
        $journal = JournalEntry::whereBetween('assign_date',array($start, $end))->where('jurnal_type','sales_commission')->where('agent_id',$id)->where('debit_credit',0)->get()->sortBy('assign_date');

        return view('report::single_agent_commission',compact('end','start','OrganizationProfile','journal','id','ag', 'opening_balance_debit', 'opening_balance_credit', 'opening_balance_invoices'));
    }


    public function filterbydate(Request $request)
    {
        $OrganizationProfile = OrganizationProfile::find(1);

        $start = date('d-m-Y', strtotime($request->from_date));

        if($request->to_date){
            $end = date('d-m-Y', strtotime($request->to_date));
        }else{
            $end = $start;
        }


        $journal = Invoice::groupBy('agents_id')
                        ->whereNotNull('agents_id')
                        ->where(DB::raw("date_format(str_to_date(invoice_date, '%d-%m-%Y'), '%Y-%m-%d')"), '<=', DB::raw("date_format(str_to_date('$end', '%d-%m-%Y'), '%Y-%m-%d')"))
                        ->join('contact', 'contact.id', 'invoices.agents_id')
                        ->selectRaw('agentcommissionAmount ,commission_type ,sum(total_amount) as sum, sum(CASE WHEN commission_type = "1" THEN (total_amount*agentcommissionAmount/100) WHEN commission_type = "2" THEN agentcommissionAmount ELSE 0 END) as payable, count(invoices.id) as totalinvoice,agents_id,display_name as agent_name,sum(total_amount-due_amount) as receivable ')
                        ->get();
        return view('report::salesbyagent',compact('end','start','OrganizationProfile','journal'));
    }

}
