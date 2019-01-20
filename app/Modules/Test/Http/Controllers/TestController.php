<?php

namespace App\Modules\Test\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TestCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(){

        return view("test::test.index");
    }

    public function create(){
        $patients       = Patient::select('serial','name')->get();
        $doctors        = Doctor::all();
        $test_category  = TestCategory::all();

        return view("test::test.create", compact('patients','doctors', 'test_category'));
    }

    public function store(Request $request){

        $this->validate($request, [
           'patient_id'             =>  'required',
           'doctor_id'              =>  'required',
           'test_category_id.*'     =>  'required',
           'test_name.*'            =>  'required',
           'body_part.*'            =>  'required',
        ]);

        DB::beginTransaction();

        try {

            for($j=0; $j < count($request->test_category_id); $j++) {

                $test                       = new Test();
                $test->patient_id           = $request->patient_id;
                $test->doctor_id            = $request->doctor_id;
                $test->test_name            = $request->test_name[$j];
                $test->test_category_id     = $request->test_category_id[$j];
                $test->body_part            = $request->body_part[$j];
                $test->status               = 1;
                $test->save();

            }

            DB::commit();

            return redirect()
                ->route('test_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Created Successfullly');

        }catch(Exception $ex){

            DB::rollBack();

            $msg = $ex->getMessage();
            return redirect()->route('test_index')
                            ->with('alert.status', 'danger')
                            ->with('alert.message', "Fail : $msg");
        }
    }

}
