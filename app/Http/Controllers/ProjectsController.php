<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Projects;
use App\Models\Companies;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\portalTypes;

class ProjectsController extends Controller
{
    //
    public function project_list()
    {
        $data['projects'] = Projects::where('is_deleted',0)->with('company', 'portal_type')->get();
        return view('projects.projects-list')->with($data);

    }

    public function add_project()
    {
        $data['Companieslist'] = Companies::all();
        $data['portalTypelist'] = portalTypes::all();
        return view('projects.add-projects')->with($data);
    }

    public function postadd_project(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'company_id' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $portal = new Projects();
        $portal->name = $request->name;
        $portal->company_id = $request->company_id;
        $portal->portal_Types_id = $request->portalTypes;
        $portal->is_deleted = 0;
        $portal->created_at = now();
        $portal->save();

        if($portal){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_project(Request $request)
    {   
        if(!empty($request->id)){
            $data['Companieslist'] = Companies::all();
            $data['portalTypelist'] = portalTypes::all();
            $data['projects'] = Projects::where(['_id' => $request->id])->first();
           
            return view('projects.add-projects')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_project(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'company_id' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $project = Projects::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                                'company_id' => $request->company_id,
                                'portal_Types_id' => $request->portalTypes
                            ]);
        if($project){
            return redirect(route('projectlist'))->with('success', 'Project updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_project($id)
    {
        if($id != ''){
            $deleteCus = Projects::where(['_id' => $id])
            ->update([
                'is_deleted' => 1,
            ]);
            if($deleteCus){

                return back()->with('success', 'Project deleted successfully');
            }else{
                return back()->with('error','Project deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }

    public function view(Request $request)
    {
        try {
            if(isset($request)){
                $data['projects'] = Projects::where(['_id' => $request->id])->with('portal' , 'company' , 'portal_type')->first();
            }
            return view('projects.view')->with($data);
        }
        catch (exception $e) {
            return back()->with('error' , $e);
        }
    }
}
