<?php

namespace App\Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact\Outlet;
use App\Models\Contact\Company;
use App\Models\Contact\Employee;
use App\Models\Contact\Contact;
use DB;

class ContactApiController extends Controller
{
    public function getContact($id)
    {
        $contact = Contact::find($id);

        $category = DB::table('contact_category')->select('contact_category_name as text', 'id as value')->get();
        $agent = DB::table('agents')
            ->select('display_name as text', 'id as value')->get();
        
        return response()->json([
            'contact'   =>  $contact,
            'category'  =>  $category,
            'agent'     =>  $agent,
        ], 201);
    }


    public function All($category_id){

        $contacts   =   Contact::where('contact_category_id', $category_id)->get();

        return response($contacts);
    }

    public function findByName(Request $request){

        if($request->id == 1 || $request->id == 2){
            $contacts   =   Contact::where("company_name","like","%$request->name%")->get();
        }
        if($request->id ==3){
            $contacts   =   Contact::where("employee_name","like","%$request->name%")->get();
        }

        return response($contacts);
    }
}
