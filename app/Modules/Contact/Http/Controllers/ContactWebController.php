<?php

namespace App\Modules\Contact\Http\Controllers;


use App\Models\AccountChart\Account;
use App\Models\Contact\OutletCompany;
use App\Models\ManualJournal\JournalEntry;
use DateTime;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

// Models
use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\Contact\Agent;
use App\Models\MoneyOut\Bill;
use App\Models\Moneyin\Invoice;
use App\Models\OrganizationProfile\OrganizationProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Contact\Road;


class ContactWebController extends Controller
{
    public function index($id)
    {
        $contacts = [];
        $agents = [];
        $contactCategories = ContactCategory::all();
        $category_id = $id;
        $date = new DateTime('now');
        $date->modify('first day of this month');
        $branch_id = session('branch_id');
        $start = $date->format('Y-m-d');
        $date->modify('last day of this month');
        $end = $date->format('Y-m-d');
        $contact_route = route("report_account_api_Contact_Item_Details",['branch'=>$branch_id,'start'=>$start,'end'=>$end,'id'=>'']);
        $contact_transaction = route("report_account_single_contact_details",['branch'=>$branch_id,'start'=>$start,'end'=>$end,'id'=>'new_id']);

        return view('contact::contact.ajax.index', compact('contact_transaction','contact_route', 'contacts', 'contactCategories', 'category_id', 'agents'));
    }

    public function create($category_id)
    {
        $companys = Contact::where('contact_category_id',2)->get();
        $roads    = Road::all();

        if($category_id == 1) {
            $outlet_id = Contact::select('serial')->orderBy('id', 'DESC')->where('contact_category_id', 1)->first();

            if ($outlet_id != Null) {
                $outlet = (int)substr($outlet_id['serial'], 4);
                $outlet = $outlet + 1;
                $outlet_id = "CUS-" . str_pad($outlet, 6, '0', STR_PAD_LEFT);
            } else {
                $outlet_id = "CUS-000001";
            }
        }

        if($category_id == 2) {
            $company_id = Contact::select('serial')->orderBy('id', 'DESC')->where('contact_category_id', 2)->first();

            if ($company_id != Null) {
                $company_id = (int)substr($company_id['serial'], 4);
                $company_id = $company_id + 1;
                $company_id = "COM-" . str_pad($company_id, 6, '0', STR_PAD_LEFT);
            } else {
                $company_id = "COM-000001";
            }
        }

        if($category_id == 3) {
            $employee_id = Contact::select('serial')->orderBy('id', 'DESC')->where('contact_category_id', 3)->first();

            if ($employee_id != Null) {
                $employee_id = (int)substr($employee_id['serial'], 4);
                $employee_id = $employee_id + 1;
                $employee_id = "EMP-" . str_pad($employee_id, 6, '0', STR_PAD_LEFT);
            } else {
                $employee_id = "EMP-000001";
            }
        }

        return view('contact::contact.create', compact('companys','roads', 'outlet_id', 'company_id', 'employee_id','category_id'));
    }

    public function create_customer()
    {
        $recruit = 1;
        $contact_categories = ContactCategory::all();
        return view('contact::contact.create', compact('contact_categories','recruit'));
    }

    public function store(Request $request, $category_id)
    {
        try
        {
            $data = $request->all();
            $user_id = Auth::user()->id;

            $contact                            = new Contact;

            if($category_id == 1){

                $this->validate($request,[
                   'display_name'   =>  'required',
                   'serial'         =>  'required',
                   'propietor'      =>  'required',
                   'outlet'         =>  'required',
                   'address'        =>  'required',
                   'company_id'     =>  'required',
                   'road_id'        =>  'required',
                   'mobile'         =>  'required',
                ]);

                $contact->display_name          = $data['display_name'];
                $contact->propietor             = $data['propietor'];
                $contact->outlet                = $data['outlet'];
                $contact->road_id               = $data['road_id'];
                $contact->address               = $data['address'];
                $contact->mobile                = $data['mobile'];
                $contact->contact_category_id   = 1;
            }

            if($category_id == 2){

                $this->validate($request,[
                    'display_name'   =>  'required',
                    'serial'         =>  'required',
                    'propietor'      =>  'required',
                    'outlet'         =>  'required',
                    'address'        =>  'required',
                    'company_id'     =>  'required',
                    'road_id'        =>  'required',
                    'mobile'         =>  'required',
                ]);

                $contact->display_name          = $data['display_name'];
                $contact->office_address        = $data['office_address'];
                $contact->office_phone          = $data['office_phone'];
                $contact->rsm_mobile            = $data['rsm_mobile'];
                $contact->tsm_mobile            = $data['tsm_mobile'];
                $contact->sr_mobile             = $data['sr_mobile'];
                $contact->contact_category_id   = 2;
            }

            if($category_id == 3) {

                $this->validate($request,[
                    'display_name'   =>  'required',
                    'serial'         =>  'required',
                    'propietor'      =>  'required',
                    'outlet'         =>  'required',
                    'address'        =>  'required',
                    'company_id'     =>  'required',
                    'road_id'        =>  'required',
                    'mobile'         =>  'required',
                ]);

                $contact->display_name          = $data['display_name'];
                $contact->employee_designation  = $data['employee_designation'];
                $contact->employee_address      = $data['employee_address'];
                $contact->employee_phone        = $data['employee_phone'];
                $contact->employee_nid          = $data['employee_nid'];
                $contact->employee_reference    = $data['employee_reference'];
                $contact->employee_mobile       = $data['employee_mobile'];
                $contact->contact_category_id   = 3;
            }

            $contact->serial                = $data['serial'];
            $contact->note                  = $data['note'];
            $contact->status                = 1;
            $contact->branch_id             = Auth::user()->branch_id;
            $contact->created_by            = $user_id;
            $contact->updated_by            = $user_id;

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $directory = 'uploads/images/outlet/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;
                $contact->image = $imageUrl;
            }

            $contact->save();

            if($category_id == 1) {
                if (isset($data['company_id'])) {

                    for ($i = 0; $i < count($data['company_id']); $i++) {

                        $outlet_company = new OutletCompany();
                        $outlet_company->contact_id = $contact->id;
                        $outlet_company->contact_category_id = 1;
                        $outlet_company->company_id = $data['company_id'][$i];
                        $outlet_company->created_by = $user_id;
                        $outlet_company->updated_by = $user_id;

                        $outlet_company->save();
                    }
                }
            }

            if($contact->save())
            {
                return redirect()
                    ->route('contact', $category_id)
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Added successfully!');
            }

            throw new \Exception("fail to add");

        }
        catch (Exception $e)
        {
            return redirect()
                ->route('contact',$category_id)
                ->with('alert.status', 'danger')
                ->with('alert.message', 'not added!');
        }
    }

    public function show($category_id, $id)
    {
        $contact    = Contact::where('contact_category_id', $category_id)->where('id', $id)->first();
        if($category_id) {
            $outlet_company = OutletCompany::where('contact_id', $id)->groupBy('contact_id')->get();
        }

        return view('contact::contact.view', compact('contact', 'outlet_road', 'category_id'));
    }

    public function showAgent($id)
    {
        $contact = Agent::find($id);
        $contact_category = "Agent";
        return view('contact::contact.view', compact('contact', 'contact_category'));
    }

    public function edit($category_id, $id)
    {
        $contact            = Contact::where('contact_category_id', $category_id)->where('id', $id)->first();
        $contact_id         = $id;
        $roads              = Road::all();
        $companys           = Contact::where('contact_category_id',2)->get();
        $selected_company   = OutletCompany::select('company_id')->where('contact_id', $id)->get();

        return view('contact::contact.edit', compact('contact', 'contact_id', 'roads','category_id', 'companys', 'selected_company'));
    }

    public function editAgent($id)
    {
        $contact = Agent::find($id);
        $contact_id = $id;
        $contact_categories = ContactCategory::all();
        $contact_category_id = 6;
        return view('contact::contact.edit', compact('contact', 'contact_categories', 'contact_category_id', 'contact_id'));
    }

    public function update($category_id, Request $request, $id)
    {
        $contact = Contact::find($id);

        try
        {
            $data = $request->all();
            $user_id = Auth::user()->id;

            if($category_id == 1){
                $contact->display_name          = $data['display_name'];
                $contact->propietor             = $data['propietor'];
                $contact->outlet                = $data['outlet'];
                $contact->road_id               = $data['road_id'];
                $contact->address               = $data['address'];
                $contact->mobile                = $data['mobile'];
                $contact->contact_category_id   = $category_id;
            }
            if($category_id == 2){
                $contact->display_name          = $data['display_name'];
                $contact->office_address        = $data['office_address'];
                $contact->office_phone          = $data['office_phone'];
                $contact->rsm_mobile            = $data['rsm_mobile'];
                $contact->tsm_mobile            = $data['tsm_mobile'];
                $contact->sr_mobile             = $data['sr_mobile'];
                $contact->contact_category_id   = $category_id;
            }
            if($category_id == 3) {
                $contact->display_name          = $data['display_name'];
                $contact->employee_designation  = $data['employee_designation'];
                $contact->employee_address      = $data['employee_address'];
                $contact->employee_phone        = $data['employee_phone'];
                $contact->employee_nid          = $data['employee_nid'];
                $contact->employee_reference    = $data['employee_reference'];
                $contact->employee_mobile       = $data['employee_mobile'];
                $contact->contact_category_id   = $category_id;
            }

            $contact->serial                = $data['serial'];
            $contact->note                  = $data['note'];
            $contact->status                = 1;
            $contact->branch_id             = Auth::user()->branch_id;
            $contact->updated_by            = $user_id;

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().".".$image->getClientOriginalExtension();
                $directory = 'uploads/images/outlet/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;
                $contact->image = $imageUrl;
            }

            $contact->update();

            if($category_id == 1){

                if(isset($data['company_id'])){

                    $delete_outlet_company =   OutletCompany::where('contact_id', $id)->groupBy('contact_id')->delete();

                    if($delete_outlet_company){

                        for ($i = 0; $i < count($data['company_id']); $i++) {

                            $outlet_company = new OutletCompany();
                            $outlet_company->contact_id            = $contact->id;
                            $outlet_company->contact_category_id   = 1;
                            $outlet_company->company_id            = $data['company_id'][$i];
                            $outlet_company->updated_by            = $user_id;

                            $outlet_company->save();
                        }
                    }

                }
            }

            if($contact->update())
            {
                return redirect()
                    ->route('contact', $category_id)
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Updated successfully!');
            }

            throw new \Exception("fail to add");

        }
        catch (Exception $e)
        { dd($e->getMessage());
            return redirect()
                ->route('contact',$category_id)
                ->with('alert.status', 'danger')
                ->with('alert.message', 'not updated!');
        }
    }

    public function destroy($category_id, $id)
    {

        try{

            if($category_id == 1) {
                $delete_outlet_roads = OutletCompany::where('contact_id', $id)->groupBy('contact_id')->delete();
            }

            $contact = Contact::where('contact_category_id', $category_id)->where('id', $id)->first();

            if($contact->delete()) {

                return redirect()
                    ->route('contact',$category_id)
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'Deleted successfully!');
            }

            else{

                return redirect()
                    ->route('contact',$category_id)
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'Sorry, cannot be Deleted.  Something wrong try again ');
            }
        }catch (\Exception $e){

            return redirect()
                ->route('contact',$category_id)
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, cannot be Deleted.  Something wrong try again ');
        }

    }

    public function destroyAgent($id)
    {
        try
        {
            $agent = Agent::find($id);

            if($agent->profile_pic_url)
            {
                $delete_path = public_path($agent->profile_pic_url);
                $delete      = unlink($delete_path);
            }

            if ($agent->delete())
            {
                return redirect()
                    ->route('contact')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Agent Deleted successfully!');
            }
            else
            {
                return redirect()
                    ->route('contact')
                    ->with('alert.status', 'alert')
                    ->with('alert.message', 'Sorry, something went wrong! Data cannot be Deleted.');
            }
        }
        catch (Exception $e)
        {
            return redirect()
                ->route('contact')
                ->with('alert.status', 'alert')
                ->with('alert.message', 'Sorry, something went wrong! Data cannot be Deleted.');
        }

    }

    public function pdf()
    {
        $OrganizationProfile = OrganizationProfile::first();
        $contacts = Contact::all();

        return view('contact::contact.pdf', compact('contacts', 'OrganizationProfile'));
    }
}
