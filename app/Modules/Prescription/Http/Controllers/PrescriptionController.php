<?php

namespace App\Modules\Prescription\Http\Controllers;

use App\Models\MedicineTakingSchedule;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TestCategory;
use App\Models\Test;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile\OrganizationProfile;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;

class PrescriptionController extends Controller
{
    public function index(){
        $prescriptions  =  Prescription::groupBy('patient_id')->get();
        return view("prescription::prescription.index", compact('prescriptions'));
    }

    public function create(){
        $patients       = Patient::select('id','serial','name')->get();
        $doctors        = Doctor::all();
        $test_category  = TestCategory::all();

        return view("prescription::prescription.create", compact('patients','doctors', 'test_category'));
    }

    public function medicineTakingSchedule($type_id){

        $medicine_taking_schedule = MedicineTakingSchedule::where('type', $type_id)->get();

        return Response::json($medicine_taking_schedule);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'date'              => 'required',
            'patient_id'        => 'required',
            'doctor_id'         => 'required',
            'medicine_name.*'   => 'required',
            'medicine_type.*'   => 'required',
            'taking_time.*'     => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }



        DB::beginTransaction();

        try {

            $prescription               = new Prescription();
            $prescription->date         = date('Y-m-d', strtotime($request->date));
            $prescription->patient_id   = $request->patient_id;
            $prescription->doctor_id    = $request->doctor_id;
            $prescription->summary      = $request->summary;

            $prescription->save();

            /*Prescription Medicine*/
                if($prescription->save()){

                    if(isset($request->medicine_name) && count($request->medicine_name) > 0) {
                        for($i=0; $i < count($request->medicine_name); $i++) {

                            $prescription_medicine                  = new PrescriptionMedicine();
                            $prescription_medicine->prescription_id = $prescription->id;
                            $prescription_medicine->medicine_name   = $request->medicine_name[$i];
                            $prescription_medicine->medicine_type   = $request->medicine_type[$i];
                            $prescription_medicine->date            = date('Y-m-d', strtotime($request->date));
                            $prescription_medicine->taking_schedule = $request->taking_schedule[$i];
                            $prescription_medicine->medicine_type   = $request->medicine_type[$i];
                            $prescription_medicine->duration        = $request->duration[$i];
                            $prescription_medicine->advise          = $request->advise[$i];

                            $prescription_medicine->save();
                        }
                    }
                }
            /*Prescription Medicine Ends*/

            /*Test*/
                if(isset($request->test_category_id) && count($request->test_category_id) > 0) {

                    for($j=0; $j < count($request->test_category_id); $j++) {

                        $test                       = new Test();
                        $test->patient_id           = $request->patient_id;
                        $test->doctor_id            = $request->doctor_id;
                        $test->test_name            = $request->test_name[$j];
                        $test->test_category_id     = $request->test_category_id[$j];
                        $test->prescription_id      = $prescription->id;
                        $test->body_part            = $request->body_part[$j];
                        $test->status               = 1;

                        $test->save();
                    }
                }
            /*Test Ends*/

            DB::commit();

            return redirect()
                ->route('prescription_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Created Successfullly');

        }catch(Exception $ex){

            DB::rollBack();

            $msg = $ex->getMessage();
            return redirect()->route('prescription_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', "Fail : $msg");
        }
    }

    public function show($id){
        $OrganizationProfile    = OrganizationProfile::find(1);
        $prescription           = Prescription::find($id);
        $prescriptions          = Prescription::where('patient_id', $prescription->patient_id)->orderBy('id','DESC')->limit(10)->get();
        $prescription_medicine  = PrescriptionMedicine::where('prescription_id', $id)->get();
        $tests                  = Test::where('prescription_id', $id)->get();

        return view("prescription::prescription.show", compact('OrganizationProfile','prescription','prescriptions','prescription_medicine','tests'));
    }

    public function edit($id){
        $patients               = Patient::select('id','serial','name')->get();
        $doctors                = Doctor::all();
        $test_category          = TestCategory::all();
        $prescription           = Prescription::find($id);
        $prescriptions          = Prescription::where('patient_id', $prescription->patient_id)->orderBy('id','DESC')->limit(10)->get();
        $prescription_medicine  = PrescriptionMedicine::where('prescription_id', $id)->get();
        $tests                  = Test::where('prescription_id', $id)->get();
        $medicine_type          = PrescriptionMedicine::select('medicine_type')->where('prescription_id', $id)->first();
        $medicine_schedule      = MedicineTakingSchedule::where('type', $medicine_type['medicine_type'])->get();

        return view("prescription::prescription.edit", compact('patients','doctors','test_category','prescription','prescriptions','prescription_medicine','tests', 'medicine_schedule'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'date'              => 'required',
            'patient_id'        => 'required',
            'doctor_id'         => 'required',
            'medicine_name.*'   => 'required',
            'medicine_type.*'   => 'required',
            'taking_time.*'     => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::beginTransaction();

        try {

            $prescription               = Prescription::find($id);
            $prescription->date         = date('Y-m-d', strtotime($request->date));
            $prescription->patient_id   = $request->patient_id;
            $prescription->doctor_id    = $request->doctor_id;
            $prescription->summary      = $request->summary;

            $prescription->save();

            /*Prescription Medicine*/
            if($prescription->save()){

                if(isset($request->medicine_name) && count($request->medicine_name) > 0) {

                    $delete_prescription_mdecine = PrescriptionMedicine::where('prescription_id', $id)->delete();

                    for($i=0; $i < count($request->medicine_name); $i++) {

                        $prescription_medicine                  = new PrescriptionMedicine();
                        $prescription_medicine->prescription_id = $prescription->id;
                        $prescription_medicine->medicine_name   = $request->medicine_name[$i];
                        $prescription_medicine->medicine_type   = $request->medicine_type[$i];
                        $prescription_medicine->date            = date('Y-m-d', strtotime($request->date));
                        $prescription_medicine->taking_schedule = $request->taking_schedule[$i];
                        $prescription_medicine->medicine_type   = $request->medicine_type[$i];
                        $prescription_medicine->duration        = $request->duration[$i];
                        $prescription_medicine->advise          = $request->advise[$i];

                        $prescription_medicine->save();
                    }
                }
            }
            /*Prescription Medicine Ends*/

            /*Test*/
            if(isset($request->test_category_id) && count($request->test_category_id) > 0) {

                $delete_test = Test::where('prescription_id', $id)->delete();

                for($j=0; $j < count($request->test_category_id); $j++) {

                    $test                       = new Test();
                    $test->patient_id           = $request->patient_id;
                    $test->doctor_id            = $request->doctor_id;
                    $test->test_name            = $request->test_name[$j];
                    $test->test_category_id     = $request->test_category_id[$j];
                    $test->prescription_id      = $prescription->id;
                    $test->body_part            = $request->body_part[$j];

                    $test->save();
                }
            }
            /*Test Ends*/

            DB::commit();

            return redirect()
                ->route('prescription_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Updated Successfullly');

        }catch(Exception $ex){

            DB::rollBack();

            $msg = $ex->getMessage();
            return redirect()->route('prescription_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', "Fail : $msg");
        }

    }
}
