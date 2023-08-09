<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Projects;
use App\Models\Companies;
use App\Models\Locations;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DataTables;

class CompaniesController extends Controller
{
    /** Getting list of all the companies with linked projects */
    public function company() {
        return view('companies.companies-list');
    }

    public function getCompanyList(Request $request)
    {
        if ($request->ajax()) {
            $data = Companies::where('is_deleted',0)->with(['location', 'projects'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('location', function($row) {
                    return $row->location->location_name; 
                })
                ->addColumn('project_count',function($row){
                    $project_count='<a id="project_count{{$key}}" data-id = "'.$row->id.'" onclick = "projectData('.$row->id.')">'.$row->projects->count().'</a>';
                    return $project_count;
                })
                ->addColumn('action', function($row){

                    $edit=route('editcompany',$row->id);
                    $delete=route('delete.company',$row->id);
                    $view=route('company.view',$row->id);

                    $actionBtn = '  <a href="'.$view.'" title="view"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="'.$edit.'" title="edit"><i class="fa fa-pencil" style="color:green"></i></a>&nbsp;&nbsp; <a href="'.$delete.'" title="delete"><i class="fa fa-trash" style="color:red"></i></a>';      
                    return $actionBtn;
                })
                ->rawColumns(['action','project_count'])
                ->make(true);
        }
    }

    public function add_company()
    {
        $data['locationlist'] = Locations::all();
        return view('companies.add-companies')->with($data);
    }

    public function postadd_company(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $company = new Companies();
        $company->name = $request->name;
        $company->location_id = $request->location;     
        $company->is_deleted = 0;
        $company->created_at = now();
        $company->save();

        if($company){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_company(Request $request)
    {   
        if(!empty($request->id)){
            $data['locationlist'] = Locations::all();
            $data['companies'] = Companies::where(['_id' => $request->id])->first();
           
            return view('companies.add-companies')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_company(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $project = Companies::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                                'location_id' => $request->location,
                            ]);
        if($project){
            return redirect(route('companylist'))->with('success', 'Project updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_company($id)
    {
        if($id != ''){
            $deleteCom = Companies::where(['_id' => $id])
            ->update([
                'is_deleted' => 1,
            ]);
            if($deleteCom){

                return back()->with('success', 'Project deleted successfully');
            }else{
                return back()->with('error','Project deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }


    public function getCompanyProjects(Request $request)
    {        
        $data = Companies::with('projects')->where(['_id' => $request->company_id])->first();       
        return $data->projects;
    }

    public function view(Request $request)
    {
        try {
            if(isset($request)){
                $data['companies'] = Companies::where(['_id' => $request->id])->with('location' , 'projects')->first();
            }
            return view('companies.view')->with($data);
        }
        catch (exception $e) {
            return back()->with('error' , $e);
        }
    }
}
