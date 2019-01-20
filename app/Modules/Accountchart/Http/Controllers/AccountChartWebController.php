<?php

namespace App\Modules\Accountchart\Http\Controllers;

use App\Models\Contact\Contact;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

// Models
use App\Models\Branch\Branch;
use App\Models\AccountChart\Account;
use App\Models\AccountChart\AccountGL;
use App\Models\AccountChart\AccountPGL;
use App\Models\AccountChart\AccountType;
use App\Models\AccountChart\ParentAccountType;
use Response;

class AccountChartWebController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return view('accountchart::account_chart.index', compact('accounts'));
    }

    public function create()
    {
        $branches               = Branch::all();
        $account_types          = AccountType::all();
        $account_gl             = AccountGL::all();
        $account_pgl            = AccountPGL::all();
        $parent_account_types   = ParentAccountType::all();
        $associate_accounts     = Contact::all();

        return view('accountchart::account_chart.create', compact('branches', 'account_types', 'parent_account_types', 'associate_accounts', 'account_gl', 'account_pgl'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_type_id' => 'required',
            'account_name'    => 'required',
        ]);

        $account_data = $request->all();
        $created_by =  Auth::user()->id;
        $updated_by =  Auth::user()->id;

        $parent_account_type = AccountType::find($account_data['account_type_id']);
        $parent_account_type_id = $parent_account_type->parent_account_type_id;

        $account = new Account;

        $account->account_name           = $account_data['account_name'];
        $account->account_code           = $account_data['account_code'];
        $account->description            = $account_data['description'];
        $account->account_type_id        = $account_data['account_type_id'];
        $account->pgl_account_type_id    = $account_data['pgl_account_type_id'];
        $account->parent_account_type_id = $parent_account_type_id;
        $account->contact_id             = $account_data['contact_id'] > 0 ? $account_data['contact_id'] : null;
        $account->created_by             = $created_by;
        $account->updated_by             = $updated_by;

        $account->save();

        if($account->save())
        {
            return redirect()
                ->route('account_chart')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Account added successfully!');
        }
        else
        {
            return redirect()
                ->route('account_chart_create')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, something went wrong! Data cannot be saved.');
        }

    }

    public function edit($id)
    {
        $account                = Account::leftjoin('account_pgl','account_pgl.id','account.pgl_account_type_id')
                                            ->leftjoin('account_gl','account_gl.id','account_pgl.account_gl_id')
                                            ->select('account.*')
                                            ->selectRaw('account_pgl.id as account_gl_id, account_pgl.id as account_pgl_id')
                                            ->where('account.id',$id)
                                            ->first();

        $branches               = Branch::all();
        $account_types          = AccountType::all();
        $account_gl             = AccountGL::all();
        $account_pgl            = AccountPGL::all();
        $parent_account_types   = ParentAccountType::all();
        $associate_accounts     = Contact::all();
        $contact_account_id     = Contact::select('account_id')->where('account_id', $id)->first();

        return view('accountchart::account_chart.edit', compact('account', 'branches', 'account_types', 'account_gl', 'account_pgl', 'parent_account_types', 'associate_accounts', 'contact_account_id', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account_type_id' => 'required',
            'account_name'    => 'required',
        ]);

            $account_data = $request->all();
            $created_by =  Auth::user()->id;
            $updated_by =  Auth::user()->id;

            $parent_account_type        = AccountType::find($account_data['account_type_id']);
            $parent_account_type_id     = $parent_account_type->parent_account_type_id;

            $account = Account::find($id);


            if ($account->required_status==1){
                return redirect()
                    ->route('account_chart')
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'You can not edit this Account!');
            }
            else{

                $account->account_name           = $account_data['account_name'];
                $account->account_code           = $account_data['account_code'];
                $account->description            = $account_data['description'];
                $account->account_type_id        = $account_data['account_type_id'];
                $account->pgl_account_type_id    = $account_data['pgl_account_type_id'];
                $account->parent_account_type_id = $parent_account_type_id;
                $account->contact_id             = $account_data['contact_id'] > 0 ? $account_data['contact_id'] : null;
                $account->updated_by             = $updated_by;
                $account->created_by             = $created_by;

                if($account->update())
                {
                    return redirect()
                        ->route('account_chart', ['id' => $id])
                        ->with('alert.status', 'success')
                        ->with('alert.message', 'Account Updated successfully!');
                }
                else
                {
                    return redirect()
                        ->route('account_chart', ['id' => $id])
                        ->with('alert.status', 'danger')
                        ->with('alert.message', 'Sorry, something went wrong! Data cannot be saved.');
                }
            }

    }

    public function destroy($id)
    {
        $account = Account::find($id);

        if ($account->required_status==1){

            return redirect()
                ->route('account_chart')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'You can not Delete this Account!');

        }else{
            if ($account->delete())
            {
                return redirect()
                    ->route('account_chart')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Account deleted successfully!');
            }
            else
            {
                return redirect()
                    ->route('account_chart')
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'Sorry, something went wrong! Data cannot be deleted.');
            }
        }


    }

    public function addGL(Request $request){

        $last_id    = AccountGL::select('serial')->orderBy('id','DESC')->first();

        if($last_id != Null){
            $last_id    =   $last_id['serial'] + 1;
        }else{
            $last_id    = 1;
        }

        $addgl                      = new AccountGL();
        
        $addgl->account_name        =    $request->account_name;
        $addgl->serial              =    $last_id;
        $addgl->account_type_id     =    $request->account_type_id;
        $addgl->save();

        $data = $addgl;
        return Response::json($data);
    }

    public function addPGL(Request $request){

        $last_id    = AccountPGL::select('serial')->orderBy('id','DESC')->first();

        if($last_id != Null){
            $last_id    =   $last_id['serial'] + 1;
        }else{
            $last_id    = 1;
        }

        $addpgl                      = new AccountPGL();

        $addpgl->account_name        =    $request->account_name;
        $addpgl->serial              =    $last_id;
        $addpgl->account_gl_id       =    $request->account_type_id;
        $addpgl->save();

        $data = $addpgl;
        return Response::json($data);
    }

    public function accountGl(){
        $accountgl = AccountGL::join('account_type','account_type.id','account_gl.account_type_id')
                                ->select('account_gl.id','account_gl.account_name','account_type.account_name as account_type_account_name')->get();
        return view('accountchart::gl.index', compact( 'accountgl'));
    }

    public function accountGlEdit($id){
         $accountgl      = AccountGL::find($id);
        $account_types   = AccountType::all();
        return view('accountchart::gl.edit', compact( 'accountgl','account_types'));
    }

    public function accountGlUpdate(Request $request, $id){

        $this->validate($request,[
           'account_type_id'   => 'required',
           'account_name'      => 'required',
        ]);

        $account_gl     = AccountGL::find($id);

        $account_gl->account_type_id   =   $request->account_type_id;
        $account_gl->account_name      =   $request->account_name;
        $account_gl->update();

        if($account_gl->update()){
            return redirect()
                ->route('account_gl')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Account GL Updated successfully!');
        }else{
            return redirect()
                ->route('account_gl')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry something went wrong!');
        }
    }

    public function accountGlDelte($id){

        $account_gl     = AccountGL::find($id);

        if($account_gl->delete()){
            return redirect()
                ->route('account_gl')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Account GL Deleted successfully!');
        }else{
            return redirect()
                ->route('account_gl')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Not Deleted, Something went wrong!');
        }
    }

    public function accountPGl(){
        $accountpgl = AccountPGL::join('account_gl','account_gl.id','account_pgl.account_gl_id')
                                ->select('account_pgl.id','account_pgl.account_name','account_gl.account_name as account_gl_account_name')
                                ->get();

        return view('accountchart::pgl.index', compact( 'accountpgl'));
    }

    public function accountPGlEdit($id){
        $accountpgl       = AccountPGL::find($id);
        $account_gls      = AccountGL::all();
        return view('accountchart::pgl.edit', compact( 'accountpgl','account_gls'));
    }

    public function accountPGlUpdate(Request $request, $id){

        $this->validate($request,[
           'account_gl_id'     => 'required',
           'account_name'      => 'required',
        ]);

        $account_pgl     = AccountPGL::find($id);

        $account_pgl->account_gl_id     =   $request->account_gl_id;
        $account_pgl->account_name      =   $request->account_name;
        $account_pgl->update();

        if($account_pgl->update()){
            return redirect()
                ->route('account_pgl')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Account PGL Updated successfully!');
        }else{
            return redirect()
                ->route('account_pgl')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry something went wrong!');
        }
    }

    public function accountPGlDelte($id){

        $account_pgl     = AccountPGL::find($id);

        if($account_pgl->delete()){
            return redirect()
                ->route('account_pgl')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Account PGL Deleted successfully!');
        }else{
            return redirect()
                ->route('account_pgl')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Not Deleted, Something went wrong!');
        }
    }

}
