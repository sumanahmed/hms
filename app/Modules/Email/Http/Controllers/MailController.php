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
use App\Models\Doctor;
use App\Models\DoctorVisitHistory;
use App\Models\WardBed;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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


        $patient        = Patient::find($id);
        $admit_date     = new DateTime($patient['admission_date']);
        $current_time   = Carbon::now()->toDayDateTimeString();
        $current_date   = new DateTime(date("Y-m-d", strtotime($current_time)) );
        $total_day      = date_diff($admit_date,$current_date)->format("%a");
        $bed_charge     = WardBed::select('daily_charge')->where('ward_id', $patient['ward_id'])->where('id', $patient['bed_id'])->first();
        $bed_charge     = $bed_charge['daily_charge'];
        $total_bed_charge = ($bed_charge * $total_day);
        $doctor         = DoctorVisitHistory::select('doctor_id')->where('patient_id', $id)->get()->toArray();
        $doctor_visit   = Doctor::whereIn('id', $doctor)->sum('visit');
        $bill           = Bill::where('patient_id', $id)->sum('amount');


        $OrganizationProfile = OrganizationProfile::first();

        $pdf = PDF::loadView('email::bill.pdf',compact('OrganizationProfile','patient','total_day','bed_charge','total_bed_charge','doctor_visit','bill'));
        return $pdf->stream('result.pdf');
        $path=uniqid().'.pdf';
        $filename = public_path('path/'.$path);
        $pdf->save($filename);

        config(['mail.from.name' => $OrganizationProfile->display_name]);

        $email=new Email();
        $email->to=$request->email_address;
        $email->subject=$request->subject;
        $email->details=$request->details;
        $email->file=$path;
        $email->created_by=Auth::user()->id;
        $email->updated_by=Auth::user()->id;
        $email->save();

        Mail::send('email::bill.email',array('email'=>$email,'logo'=>$OrganizationProfile),function($messeg) use ($pdf){

            $messeg->to(Input::get('email_address'))->subject(Input::get('subject'));
            $messeg->attachData($pdf->output(), "Invoice.pdf");

        });

        return redirect()->back()->with('msg','Email sent successfully.Pleas Check your Email');
    }
}
