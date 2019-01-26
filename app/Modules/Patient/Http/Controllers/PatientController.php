<?php

namespace App\Modules\Patient\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorVisitHistory;
use App\Models\LabReport;
use App\Models\PatientCurrentStatus;
use App\Models\Prescription;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\Ward;
use App\Models\WardBed;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Response;
use App\Models\PrescriptionMedicine;
use App\Models\OrganizationProfile\OrganizationProfile;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index(){
        $patients  =   Patient::all();
        return view('patient::index',compact('patients'));
    }

    public function create(){
        $duty_doctors       = Doctor::where('doctor_type',1)->get();
        $supervised_doctors = Doctor::where('doctor_type',2)->get();
        $patient_id         = Patient::select('serial')->orderBy('created_at','DESC')->first();

        if($patient_id != null){
            $patient_id = $patient_id['serial'] + 1;
            $patient_id = "PID-".str_pad($patient_id, 6, '0', STR_PAD_LEFT);
        }else{
            $patient_id = 1;
            $patient_id = "PID-".str_pad($patient_id, 6, '0', STR_PAD_LEFT);
        }

        $wards      = Ward::all();
        $beds       = WardBed::all();

        return view('patient::create',compact('duty_doctors','supervised_doctors', 'patient_id','wards','beds'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'                  =>  'required|min:5|max:35',
            'age'                   =>  'required',
            'gender'                =>  'required',
            'blood_pressure'        =>  'required|numeric',
            'weight'                =>  'required|numeric',
            'problem'               =>  'required',
            'supervise_doctor_id'   =>  'required',
            'mobile'                =>  'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $serial   =   trim($request->serial, "PID-");

        DB::beginTransaction();

        try {

            $patient                        = new Patient();

            $patient->serial                = $serial;
            $patient->name                  = $request->name;
            $patient->age                   = $request->age;
            $patient->blood_pressure        = $request->blood_pressure;
            $patient->weight                = $request->weight;
            $patient->problem               = strip_tags($request->problem);
            $patient->supervise_doctor_id   = $request->supervise_doctor_id;
            $patient->admit_status          = $request->admit_status;
            $patient->ward_id               = $request->ward_id;
            $patient->bed_id                = $request->bed_id;
            $patient->admission_date        = date('Y-m-d', strtotime($request->admission_date));
            $patient->discharge_date        = null;
            $patient->email                 = $request->email;
            $patient->mobile                = $request->mobile;

            if($request->hasFile('image')){
                $image          = $request->file('image');
                $image_name     = time().$image->getClientOriginalName();
                $fileurl        = $image->move('patient/', $image_name);
                $patient->image = $fileurl;
            }

            if($patient->save()) {

                if (count($request->symptom) > 0) {

                    for ($i = 0; $i < count($request->symptom); $i++) {

                        $patient_current_status             = new PatientCurrentStatus();
                        $patient_current_status->patient_id = $patient->id;
                        $patient_current_status->symptom    = $request->symptom[$i];
                        $patient_current_status->status     = $request->status[$i];
                        $patient_current_status->doctor_id  = $request->doctor_id[$i];
                        
                        $patient_current_status->save();

                    }

                }


                $doctor         = Doctor::find($patient->supervise_doctor_id);
                $doctor_visit   = $doctor['visit'];

                $doctor_visit                   = new DoctorVisitHistory();
                $doctor_visit->patient_id       = $patient->id;
                $doctor_visit->doctor_id        = $patient->supervise_doctor_id;
                $doctor_visit->summary          = "from_admit";

                $doctor_visit->save();

            }

            DB::commit();

            return redirect()
                ->route('patient_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Created Successfullly');

        }catch(Exception $ex){

            DB::rollBack();

            $msg = $ex->getMessage();
            return redirect()->route('patient_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', "Fail : $msg");
        }
    }

    public function edit($id){
        $patient            = Patient::find($id);
        $duty_doctors       = Doctor::where('doctor_type',1)->get();
        $supervised_doctors = Doctor::where('doctor_type',2)->get();
        $wards              = Ward::all();
        $patient_bed_id     = Patient::select('bed_id')->where('id','!=', $id)->where('ward_id', $patient->ward_id)->get()->toArray();
        $beds               = WardBed::select('id','bed_no')->whereNotIn('id', $patient_bed_id)->where('ward_id', $patient->ward_id)->get();
        $patient_status     = PatientCurrentStatus::where('patient_id', $id)->get();

        return view('patient::edit',compact('patient','duty_doctors','supervised_doctors','wards','beds','patient_status'));
    }

    public function show($id){

        $prescriptions          = Prescription::where('patient_id',$id)->orderBy('id','DESC')->limit('5')->get();
        $lab_reports            = Test::join('lab_reports','lab_reports.test_id','tests.id')
                                                ->where('tests.patient_id',$id)
                                                ->orderBy('lab_reports.id','DESC')->limit('5')
                                                ->get();
        $patient                = Patient::find($id);
        $patient_status         = PatientCurrentStatus::where('patient_id', $id)->get();

        return view('patient::show',compact('OrganizationProfile','prescriptions','tests','lab_reports','patient','patient_status'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name'                  =>  'required|min:5|max:35',
            'age'                   =>  'required',
            'gender'                =>  'required',
            'blood_pressure'        =>  'required|numeric',
            'weight'                =>  'required|numeric',
            'problem'               =>  'required',
            'supervise_doctor_id'   =>  'required',
            'mobile'                =>  'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $serial   =   trim($request->serial, "PID-");

        DB::beginTransaction();

        try {

            $patient                        = Patient::find($id);

            $patient->serial                = $serial;
            $patient->name                  = $request->name;
            $patient->age                   = $request->age;
            $patient->blood_pressure        = $request->blood_pressure;
            $patient->weight                = $request->weight;
            $patient->problem               = strip_tags($request->problem);
            $patient->supervise_doctor_id   = $request->supervise_doctor_id;
            $patient->admit_status          = $request->admit_status;
            $patient->ward_id               = $request->ward_id;
            $patient->bed_id                = $request->bed_id;
            $patient->admission_date        = date('Y-m-d', strtotime($request->admission_date));
            $patient->discharge_date        = date('Y-m-d', strtotime($request->discharge_date));;
            $patient->email                 = $request->email;
            $patient->mobile                = $request->mobile;

            if($request->hasFile('image')){
                $image          = $request->file('image');
                $image_name     = time().$image->getClientOriginalName();
                $fileurl        = $image->move('patient/', $image_name);
                $patient->image = $fileurl;
            }


            if($patient->save()) {

                if (count($request->symptom) > 0) {

                    $delete_patient_current_status = PatientCurrentStatus::where('patient_id', $id)->delete();

                    for ($i = 0; $i < count($request->symptom); $i++) {

                        $patient_current_status             = new PatientCurrentStatus();
                        $patient_current_status->patient_id = $patient->id;
                        $patient_current_status->symptom    = $request->symptom[$i];
                        $patient_current_status->status     = $request->status[$i];
                        $patient_current_status->doctor_id  = $request->doctor_id[$i];

                        $patient_current_status->save();

                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('patient_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Updated Successfullly');

        }catch(Exception $ex){

            DB::rollBack();

            $msg = $ex->getMessage();
            return redirect()->route('patient_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', "Fail : $msg");
        }
    }

    public function delete($id){

        $item_use = Prescription::where('patient_id', $id)->get();
        if(count($item_use) > 0)
        {
            return redirect()
                ->route('inventory')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, Patient use in Prescription. You can not delete this Patient.');
        }

        $patient = Patient::find($id);

        if($patient->delete()){

            if (isset($patient->image)) {
                $delete_path             = public_path($patient->image);
                if(file_exists($delete_path)){
                    $delete  = unlink($delete_path);
                }
            }
            return redirect()
                ->route('patient_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Deleted successfully!!!');
        }
        return redirect()
            ->route('patient_index')
            ->with('alert.status', 'danger')
            ->with('alert.message', 'Something went to wrong!!!');

    }

    public function patientGetBed($ward_id){
        $patient_bed_id = Patient::select('bed_id')->where('ward_id', $ward_id)->get()->toArray();
        $beds           = WardBed::select('id','bed_no')->whereNotIn('id', $patient_bed_id)->where('ward_id', $ward_id)->get();

        return Response::json($beds);
    }

    public function prescription($id){
        $prescription           = Prescription::select('id')->where('patient_id', $id)->first();

        if($prescription != null){
            return redirect()->route('prescription_show',$prescription->id);
        }else{
            return redirect()
                ->route('patient_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Prescription does not Exist!');
        }

    }

}
