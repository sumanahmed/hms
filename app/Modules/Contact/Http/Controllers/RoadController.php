<?php

namespace App\Modules\Contact\Http\Controllers;

use App\Models\Contact\ContactCategory;
use Illuminate\Http\Request;
use App\Models\Contact\Road;
use App\Models\Contact\Contact;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class RoadController extends Controller
{
    public function index(){
        $roads  =  Road::all();
        return view("contact::road.index",compact('roads'));
    }

    public function create(){
        return view("contact::road.create");
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
        ]);

        $road               = new Road();

        $road->name         = $request->name;
        $road->created_by   = Auth::user()->id;
        $road->updated_by   = Auth::user()->id;

        if($road->save()){
            return redirect()
                ->route('road_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Road added successfully!');
        }else{
            return redirect()
                ->route('road_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'Something went wrong');
        }
    }

    public function edit($id){
        $road = Road::find($id);
        return view("contact::road.edit",compact('road'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name'=>'required',
        ]);

        $road               = Road::find($id);

        $road->name         = $request->name;
        $road->created_by   = Auth::user()->id;
        $road->updated_by   = Auth::user()->id;

        if($road->update()){
            return redirect()
                ->route('road_index')
                ->with('alert.status', 'success')
                ->with('alert.message', 'Road updated successfully!');
        }else{
            return redirect()
                ->route('road_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'not updated!Something went wrong');
        }
    }

    public function destroy($id){

        $contact = Contact::where('road_id', $id)->first();

        if(empty($contact)){

            $road = Road::find($id);

            if($road->delete()){
                return redirect()
                    ->route('road_index')
                    ->with('alert.status', 'success')
                    ->with('alert.message', 'Road deleted successfully!');
            }else{
                return redirect()
                    ->route('road_index')
                    ->with('alert.status', 'danger')
                    ->with('alert.message', 'not deleted!Something went wrong');
            }
        } else{
            return redirect()
                ->route('road_index')
                ->with('alert.status', 'danger')
                ->with('alert.message', 'can not deleted! Because road use in outlet');
        }

    }

}
