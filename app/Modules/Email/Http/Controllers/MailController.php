<?php

namespace App\Modules\Email\Http\Controllers;


use App\Models\Email\Email;
use App\Models\OrganizationProfile\OrganizationProfile;
use App\Models\Patient;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Bill;
use App\Models\BillEntry;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\LabReport;

class MailController extends Controller
{
    public function mailView($id){
        $patient = Patient::find($id);
        return view('email::bill.mailView',compact('patient'));
    }

    public function mailSend(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'email_address' => 'required',
            'subject' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator);
        }

        $bill                   = Bill::find($id);
        $OrganizationProfile    = OrganizationProfile::find(1);
        $bill_entry             = BillEntry::where('bill_id', $id)->get();        

        $pdf = PDF::loadView('email::bill.pdf',compact('OrganizationProfile','bill','bill_entry'));
        //return $pdf->stream('result.pdf');
        $path=uniqid().'.pdf';
        $filename = public_path('path/'.$path);
        $pdf->save($filename);

        config(['mail.from.name' => $OrganizationProfile->display_name]);

        $email              = new Email();
        $email->to          = $request->email_address;
        $email->subject     = $request->subject;
        $email->details     = $request->details;
        $email->file        = $path;
        $email->save();

        Mail::send('email::bill.email',array('email'=>$email,'logo'=>$OrganizationProfile),function($message) use ($pdf){

            $message->to(Input::get('email_address'))->subject(Input::get('subject'));
            $message->attachData($pdf->output(), "Bill.pdf");

        });

        return redirect()->back()->with('msg','Email sent successfully.Pleas Check your Email');
    }
    
    public function reportMailView($id){
        $patient = Patient::find($id); 
        return view('email::report.mailView',compact('patient'));
    }
    
    public function reportMailSend(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'email_address' => 'required',
            'subject' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator);
        }

        $OrganizationProfile    = OrganizationProfile::find(1);
        $lab_reports            = LabReport::join('tests','tests.id','lab_reports.test_id')
                                ->where('lab_reports.test_id', $id)
                                ->select('lab_reports.test_id','lab_reports.report_no','tests.patient_id')
                                ->groupBy('tests.patient_id')
                                ->orderBy('lab_reports.id','DESC')
                                ->limit(10)
                                ->get();


        $report                 = LabReport::join('tests','tests.id','lab_reports.test_id')
                                ->where('lab_reports.test_id', $id)
                                ->select('lab_reports.*','tests.patient_id')
                                ->where('lab_reports.test_id', $id)
                                ->first();  
                                
        $patient             = Patient::find($id);

        $pdf = PDF::loadView('email::report.pdf',compact('OrganizationProfile','lab_reports','report','patient'));
        //return $pdf->stream('Lab Report.pdf');
        $path=uniqid().'.pdf';
        $filename = public_path('path/'.$path);
        $pdf->save($filename);

        config(['mail.from.name' => $OrganizationProfile->display_name]);

        $email              = new Email();
        $email->to          = $request->email_address;
        $email->subject     = $request->subject;
        $email->details     = $request->details;
        $email->file        = $path;
        $email->save();

        Mail::send('email::report.email',array('email'=>$email,'logo'=>$OrganizationProfile),function($message) use ($pdf){

            $message->to(Input::get('email_address'))->subject(Input::get('subject'));
            $message->attachData($pdf->output(), "Bill.pdf");

        });

        return redirect()->back()->with('msg','Email sent successfully.Pleas Check your Email');
    }
}
