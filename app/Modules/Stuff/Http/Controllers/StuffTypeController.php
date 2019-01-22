<?php

namespace App\Modules\Stuff\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StuffType;

class StuffTypeController extends Controller
{
    public function index(){
        $types  =   StuffType::all();
        return view('stuff::stuff_type.index',compact('types'));
    }

    public function create(){
        return view('stuff::stuff_type.create');
    }

    public function store(Request $request){

        $this->validate($request,[
            'name'      => 'required|min:5|max:35',
            'sallary'   => 'required',
        ]);

        try {

            $stuff_type              = new StuffType();

            $stuff_type->name        = $request->name;
            $stuff_type->sallary     = $request->sallary;
            $stuff_type->summary     = $request->summary;

            if($stuff_type->save()){
                return redirect()
                    ->route('stuff_type_index')
                    ->with('alert.status', 'success')
                    ->with('alert.message','Created Successfullly');
            } else {
                return redirect()
                    ->route('stuff_type_index')
                    ->with('alert.status', 'danger')
                    ->with('alert.message','not created ! Something went wrong');
            }

        }

        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function edit($id){
        $stuff_type  =   StuffType::find($id);
        return view('stuff::stuff_type.edit',compact('stuff_type'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'type'=>'required',
            'name'=>'required|min:5|max:35',
            'mobile'=>'required|numeric|min:11|max:11',
            'gender'=>'required',
            'degree'=>'required',
            'nid'=>'required|numeric|unique:stuffs|min:10|max:14',
            'joining_date'=>'required',
        ]);

        try {

            $stuff = Stuff::find($id);

            $stuff->type         = $request->type;
            $stuff->name         = $request->name;
            $stuff->mobile       = $request->mobile;
            $stuff->age          = $request->age;
            $stuff->gender       = $request->gender;
            $stuff->nid          = $request->nid;
            $stuff->degree       = $request->degree;
            $stuff->joining_date = date('Y-m-d', strtotime($request->joining_date));

            if($request->hasFile('image')){

                if ($stuff->image) {
                    $delete_path             = public_path($stuff->image);
                    if(file_exists($delete_path)){
                        $delete  = unlink($delete_path);
                    }
                }

                $image       = $request->file('image');
                $image_name  = time().$image->getClientOriginalName();
                $fileurl     = $image->move('stuff/', $image_name);
                $stuff->image = $fileurl;
            }


            if($stuff->save()){
                return redirect()
                    ->route('stuff_index')
                    ->with('alert.status', 'success')
                    ->with('alert.message','Updated Successfullly');
            } else {
                return redirect()
                    ->route('stuff_index')
                    ->with('alert.status', 'danger')
                    ->with('alert.message','Not Updated');
            }


        }

        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function delete($id){

        $type = Stuff::where('stuff_type_id', $id)->get();
        if(count($type) > 0)
        {
            return redirect()
                ->route('stuff_type_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Sorry, This Type use in Stuff. You can not delete this Type.');
        }


        $stuff_type = StuffType::find($id);

        if($stuff_type->delete()){
            return redirect()
                ->route('stuff_type_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Deleted successfully!!!');
        }
        return redirect()
            ->route('stuff_type_index')
            ->with('alert.status', 'danger')
            ->with('alert.message', 'not deleted, Something went to wrong!!!');

    }
}
