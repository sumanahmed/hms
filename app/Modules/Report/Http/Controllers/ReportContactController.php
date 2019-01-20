<?php

namespace App\Modules\Report\Http\Controllers;

use App\Models\Branch\Branch;
use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\ManualJournal\JournalEntry;
use App\Models\AccountChart\Account;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Modules\Report\Http\Response\ContactReport;
use App\User;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PDF;
use App\Models\Email\Email;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;


class ReportContactController extends Controller
{

  public function apiAlphaSearch(Request $request)
  {
    $date = new DateTime('now');
    $date->modify('first day of this month');
    $start = $date->format('Y-m-d');
       //end
    $date->modify('last day of this month');
    $end = $date->format('Y-m-d');

    $branch_id = session('branch_id');

    $contact = new ContactReport();
    if(array_key_exists('type_from',$request->all()))
    {
      $list = $contact->allByAlphaRange($branch_id,trim($request->type_from),trim($request->type_to));
    }
    elseif((array_key_exists('contact_name',$request->all())))
    {
      $list = $contact->allByContact($branch_id,$request->contact_name);
    }
    elseif((array_key_exists('from_date',$request->all())))
    {

      $start = date("Y-m-d",strtotime($request->start));
      $end =  date("Y-m-d",strtotime($request->end));

      $list = $contact->allByBranch($branch_id);
    }
    else
    {
      if($branch_id==1)
      {
        $list = $contact->all();
      }else{
        $list = $contact->allByBranch($branch_id);
      }
    }


    $list = $contact->contactList($list,$start,$end);

    return response($list);
  }


  public function apiContactName(Request $request)
  {
    $date = new DateTime('now');
    $date->modify('first day of this month');
    $start = $date->format('Y-m-d');
    $date->modify('last day of this month');
    $end = $date->format('Y-m-d');

    $q= "%".trim($request->name)."%";
    $branch_id = session('branch_id');

    $url = route("report_account_contact_list_contact_by_search",["contact_name"=>$request->name]);

    $list = Contact::where("contact.display_name","like",$q)->select("display_name as display_name", "id as id")->take(10)->get();

    foreach ($list as $item){
      $contact_url = route("report_account_single_contact_details",['id'=>$item->id,"branch"=>$branch_id,"start"=>$start,"end"=>$end]);

      $item->url = $contact_url;
    }

    return response($list);
  }


  public function index()
  {
    $branch_id = session('branch_id');
    $current_branch=Branch::find($branch_id);
    $contact = new ContactReport();
    $category = ContactCategory::all();
    if($branch_id==1)
    {
      $list = $contact->all();
    }else{
      $list = $contact->allByBranch($branch_id);
    }
    $date = new DateTime('now');
    $date->modify('first day of this month');

    $branch=Branch::all();
    $start = $date->format('Y-m-d');
    $date->modify('last day of this month');
    $end = $date->format('Y-m-d');
    $OrganizationProfile = OrganizationProfile::find(1);

    $list = [];

    return view('report::contact.contactindex',compact('category','current_branch','branch','list','OrganizationProfile','start','end'));
  }


  public function contactBySearch(Request $request)
  {

    if(empty($request["contact_name"]))
    {
      return back()->with('alert.status', 'danger')
      ->with('alert.message', 'Sorry name is empty.');
    }
    $category = ContactCategory::all();
    $branch_id = session('branch_id');
    $branch=Branch::all();
    if($request->branch_id)
    {
      $branch_id =  $request->branch_id;
    }
    $date = new DateTime('now');
    $date->modify('first day of this month');
    $start = $date->format('Y-m-d');
    $date->modify('last day of this month');
    $end = $date->format('Y-m-d');
    $current_branch=Branch::find($branch_id);
    $contact = new ContactReport();
    $list = $contact->allByContact($branch_id,$request->contact_name);
    $OrganizationProfile = OrganizationProfile::find(1);
    $list = [];

    return view('report::contact.contactindex',compact('category','current_branch','branch','list','OrganizationProfile','start','end'));
  }


  public function AlpahabetSearch(Request $request)
  {
    $time_start = microtime(true);
    if(empty($request["type_from"]) || empty($request["type_to"]))
    {
      return back()->with('alert.status', 'danger')
      ->with('alert.message', 'Sorry Range is empty.');
    }

    $category = ContactCategory::all();
    $branch_id = session('branch_id');

    $branch=Branch::all();
    if($request->branch_id)
    {
      $branch_id =  $request->branch_id;
    }

    $date = new DateTime('now');
    $date->modify('first day of this month');
    $start = $date->format('Y-m-d');
    $date->modify('last day of this month');
    $end = $date->format('Y-m-d');
    $current_branch=Branch::find($branch_id);
    $contact = new ContactReport();
    $list = $contact->allByAlphaRange($branch_id,trim($request->type_from),trim($request->type_to));
    $OrganizationProfile = OrganizationProfile::find(1);

      // $list = $contact->contactList($list,$start,$end);
      //dd($list);
        //  $list = [];
      //  echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);


    return view('report::contact.contactindex',compact('category','current_branch','branch','list','OrganizationProfile','start','end'));
  }


  public function indexSearch(Request $request)
  {
    if(empty($request["from_date"]) || empty($request["to_date"]))
    {
      return back()->with('alert.status', 'danger')
      ->with('alert.message', 'Sorry date is empty.');
    }
    $category = ContactCategory::all();
    $branch_id = session('branch_id');

    $branch=Branch::all();
    if($request->branch_id)
    {
      $branch_id =  $request->branch_id;
    }
    $current_branch=Branch::find($branch_id);
    $contact = new ContactReport();
    $list = [];
    $start = date("Y-m-d",strtotime($request->from_date));
    $end =  date("Y-m-d",strtotime($request->to_date));
    $OrganizationProfile = OrganizationProfile::find(1);

    return view('report::contact.contactindex',compact('category','current_branch','branch','list','OrganizationProfile','start','end'));
  }


  public function ContactDetails(Request $request,$id,$branch,$start,$end, $pdfView=0)
  {
    $list = [];
    $flatrow = isset($request->flat)?1:0;
    $groupbytype = isset($request->group)?1:0;
    $customer = Contact::find($id,['display_name','id']);
    $start = $start;
    $end =  $end;
    $branch_id = $branch;
    $current_branch=Branch::find($branch_id);
    $OrganizationProfile = OrganizationProfile::find(1);
    $contact = new ContactReport();
    $openning_balance = $contact->openningBalance($id,$start);
    $branch=Branch::all();
       //dd($contact);
    $openning_balance = $contact->sumDrCR($openning_balance);


    if($flatrow==1)
    {
      $list = $contact->findById($id,$start,$end);
      $list = $list->sortBy('assign_date');
    }
    if($groupbytype==1)
    {
      $list = $contact->findById($id,$start,$end,"true");
    }
    if($groupbytype==0 && $flatrow==0)
    {
     $flatrow = 1;
     $list = $contact->findById($id,$start,$end);
     $list = $list->sortBy('assign_date');
    }

      //Account Filter Only Showing For DateWise View For Now
        if($groupbytype!=1)
        {
          //Accounts Name Storing in a variable for Dropdown
          //First We will group by accounts from list
          $list_details = $list->groupBy('account_name_id')->toArray();

          //Then loop through the grouped array and get account name and accoutn id
          foreach($list_details as $list_details_loop){

            $account_name[] = Account::selectRaw('account_name as account_name, id as account_id')
                              ->where('account.id', '=', $list_details_loop[0]['account_name_id'])
                              ->get()
                              ->toArray();
        }
      //Account Filter Ends

    }
    if(isset($pdfView) )
    {
        if($pdfView == 1){
            $pdf = PDF::loadView('report::contact.pdf',compact('account_name', 'branch','current_branch','customer','openning_balance','list','OrganizationProfile','flatrow','groupbytype','end','start','id'));
            return $pdf;
        }
    }

    return view('report::contact.show',compact('account_name', 'branch','current_branch','customer','openning_balance','list','OrganizationProfile','flatrow','groupbytype','end','start','id'));
  }


 public function ContactDetailsSearch(Request $request, $id)
 {
     if(empty($request["from_date"]) || empty($request["to_date"]))
     {
       return back()->with('alert.status', 'danger')
       ->with('alert.message', 'Sorry! Date is empty.');
     }

     $branch_id = session('branch_id');
     $branch = User::find($id);

     if($branch){
      $branch_id = $branch['branch_id'];
     }

      return redirect::route("report_account_single_contact_details",["id"=>$id,'branch'=>$branch_id,"start"=>$request['from_date'],"end"=>$request['to_date']]);
 }

 public function mailView($id, $branch, $start, $end, $display_name ){
      $contact = Contact::find($id);
     return view('report::contact.mailView',compact('contact','branch','id', 'start', 'end', 'display_name'));
 }

 public function mailSend(Request $request){

    $validator = Validator::make($request->all(), [
        'email_address' => 'required',
        'subject' => 'required',
        'details' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect::back()->withErrors($validator);
    }


     $pdf  = $this->ContactDetails( $request, $request->id, $request->branch, $request->start, $request->end, $request->pdfView);
     //return $pdf->stream('Ledger.pdf');


     $path=uniqid().'.pdf';
     $filename = public_path('path/'.$path);
     $pdf->save($filename);

     $OrganizationProfile = OrganizationProfile::first();
     config(['mail.from.name' => $OrganizationProfile->display_name]);

     $email= new Email();
     $email->to         = $request->email_address;
     $email->subject    = $request->subject;
     $email->details    = $request->details;
     $email->file       = $path;
     $email->created_by = Auth::user()->id;
     $email->updated_by = Auth::user()->id;
     $email->save();


     Mail::send('report::contact.email',array('email'=>$email,'OrganizationProfile'=>$OrganizationProfile),function($messeg) use ($pdf){

         $messeg->to(Input::get('email_address'))->subject(Input::get('subject'));
         $messeg->attachData($pdf->output(), "Invoice.pdf");

     });

     return redirect()->back()->with('msg','Email sent successfully.Pleas Check your Email');
 }

}
