<?php

namespace App\Modules\Report\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MoneyOut\Expense;
use App\Models\AccountChart\Account;
use App\Models\ManualJournal\JournalEntry;
use App\Models\OrganizationProfile\OrganizationProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;


class ReportExpenseController extends Controller
{
    
    protected $increasing_limit = null;

    public function __construct(){

      $this->increasing_limit = DB::statement('SET SESSION group_concat_max_len = 100000000000');

    }

    public function apiAlphaSearch(Request $request)
    {
        $date = new DateTime('now');
        $date->modify('first day of this month');
        $start = $date->format('Y-m-d');
        //end
        $date->modify('last day of this month');
        $end = $date->format('Y-m-d');

        $branch_id = session('branch_id');

        $expense = new Expense();
        if(array_key_exists('type_from',$request->all()))
        {
            $list = $expense->allByAlphaRange($branch_id,trim($request->type_from),trim($request->type_to));
        }
        elseif((array_key_exists('contact_name',$request->all())))
        {
            $list = $expense->allByContact($branch_id,$request->contact_name);
        }
        elseif((array_key_exists('from_date',$request->all())))
        {

            $start = date("Y-m-d",strtotime($request->start));
            $end =  date("Y-m-d",strtotime($request->end));

            $list = $expense->allByBranch($branch_id);
        }
        else
        {
            if($branch_id==1)
            {
                $list = $expense->all();
            }else{
                $list = $expense->allByBranch($branch_id);
            }
        }


        $list = $expense->contactList($list,$start,$end);

        return response($list);
    }



    public function expenseLedger(){

        $OrganizationProfile = OrganizationProfile::find(1);
      
      //finding today; start & end are same as it is default page
      $start = Carbon::now()->format('Y-m-d 00:00:00');
      $end = Carbon::now()->format('Y-m-d 23:59:59');


      //finding all data between the date range
      $expense = JournalEntry::join('expense','expense.id','=','journal_entries.expense_id')
                                   ->join('contact','contact.id','=','expense.vendor_id')
                                   ->join('account','account.id','=','expense.account_id') 
                     ->where('debit_credit','=',0)
                     ->where('jurnal_type','=','expense')
                     ->whereBetween('journal_entries.assign_date',[$start,$end])
                     ->groupBy('expense.account_id')
                     ->selectRaw('GROUP_CONCAT(journal_entries.id) as jid , GROUP_CONCAT(journal_entries.amount) as jamount,
                                       GROUP_CONCAT(journal_entries.assign_date) as jdate,
                                       GROUP_CONCAT(contact.display_name) as evendor,
                                       GROUP_CONCAT(expense.reference) as eref,
                                       GROUP_CONCAT(expense.note) as enote,
                                       journal_entries.id as id,
                                       account.account_name as expenseAccountID')
                     ->get();

        //dd($expense);

      $opening_balance = JournalEntry::join('expense','expense.id','=','journal_entries.expense_id')
                                   ->join('account','account.id','=','expense.account_id')
                                   ->where('debit_credit','=',0)
                                   ->where('jurnal_type','=','expense')
                                   ->where('journal_entries.assign_date' , '<' , $start)
                                   ->groupBy('expense.account_id')
                                   ->selectRaw('SUM(journal_entries.amount) as sum, journal_entries.id as id, account.account_name as expenseAccountID')
                                   ->get();
                                   
                                   

        //merging array preserving data of same keys
        $result = array_map(function($expense, $opening_balance)
        {  
            return array_merge(isset($expense) ? $expense : array(), isset($opening_balance) ? $opening_balance : array());
        },$expense->toArray(), $opening_balance->toArray());
        
        $start = date('d-m-Y', strtotime($start));
        $end = date('d-m-Y', strtotime($end));

      return view('report::expense_ledger',compact('OrganizationProfile', 'result', 'expense', 'start','end'));
    }

    public function expenseLedgerFilter(Request $request){

        $OrganizationProfile = OrganizationProfile::find(1);

        
        //finding start $ end from request
        $start = strtotime($request->from_date);
        $start = date('Y-m-d 00:00:00', $start);

        $end = strtotime($request->to_date);
        $end = date('Y-m-d 23:59:59', $end);


        //finding all data between the date range
        $expense = JournalEntry::join('expense','expense.id','=','journal_entries.expense_id')
                                   ->join('contact','contact.id','=','expense.vendor_id')
                                   ->join('account','account.id','=','expense.account_id') 
                                   ->where('debit_credit','=',0)
                                   ->where('jurnal_type','=','expense')
                                   ->whereBetween('journal_entries.assign_date',[$start,$end])
                                   ->groupBy('expense.account_id')
                                   ->selectRaw('GROUP_CONCAT(journal_entries.id) as jid , GROUP_CONCAT(journal_entries.amount) as jamount,
                                       GROUP_CONCAT(journal_entries.assign_date) as jdate,
                                       GROUP_CONCAT(contact.display_name) as evendor,
                                       GROUP_CONCAT(expense.reference) as eref,
                                       GROUP_CONCAT(expense.note) as enote,
                                       account.account_name as expenseAccountID')
                                   ->get();

        //finding opening balance
        $opening_balance = JournalEntry::join('expense','expense.id','=','journal_entries.expense_id')
                                   ->join('account','account.id','=','expense.account_id')
                                   ->where('debit_credit','=',0)
                                   ->where('jurnal_type','=','expense')
                                   ->where('journal_entries.assign_date' , '<' , $start)
                                   ->groupBy('expense.account_id')
                                   ->selectRaw('SUM(journal_entries.amount) as sum, journal_entries.id as id, account.account_name as expenseAccountID')
                                //   ->selectRaw('SUM(journal_entries.amount) as sum,
                                //                 account.account_name as expenseAccountID')
                                   ->get();



        //merging array preserving data of same keys
        $result = array_map(function($expense, $opening_balance)
        {  
            return array_merge(isset($expense) ? $expense : array(), isset($opening_balance) ? $opening_balance : array());
        },$expense->toArray(), $opening_balance->toArray());

        $start = date('d-m-Y', strtotime($start));
        $end = date('d-m-Y', strtotime($end));


        return view('report::expense_ledger',compact('OrganizationProfile', 'result', 'start', 'end', 'expense'));
    }
}
