<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Modules;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use DataTables;

class ModulesController extends Controller
{

     /**
     * Ajax datatable data for module listing
     */
    public function moduleAjaxData(Request $request){
        if ($request->ajax()) {
            $data =  Modules::where('is_deleted', 0)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $edit=route('editmodule',$row->id);
                    $delete=route('delete.module',$row->id);
                    $actionBtn = '<a href="'.$edit.'" title="edit"><i class="fa fa-pencil" style="color:green"></i></a>&nbsp;&nbsp; <a href="'.$delete.'" title="delete"><i class="fa fa-trash" style="color:red"></i></a>';      
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    //
    public function module_list()
    {
        $data['modules'] = Modules::where('is_deleted', 0)->get();
        // $submodule = DB::table('modules as md')
        //     ->join('modules as subm','md.modules.id','=','subm.module_id')->where('md.is_deleted', 0)
        //     ->get();
        // dd($submodule);
        return view('modules.modules-list')->with($data);

    }

    public function add_module()
    {
        return view('modules.add-modules');
    }

    public function add_submodule()
    {   
        $data['modulelist'] = Modules::where(['is_deleted' => 0])->get();
        return view('modules.add-sub-modules')->with($data);
    }

    public function postadd_module(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $portal = new Modules();
        $portal->name = $request->name;
        $portal->module_id = 0;
        $portal->is_deleted = 0;
        $portal->created_at = now();
        $portal->save();

        if($portal){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function postadd_submodule(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'module' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }
        
        $portal = new Modules();
        $portal->name = $request->name;
        $portal->module_id = $request->module;
        $portal->is_deleted = 0;
        $portal->created_at = now();
        $portal->save();

        if($portal){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_module(Request $request)
    {   
        if(!empty($request->id)){
            $module = Modules::where(['_id' => $request->id])->first();
           
            return view('modules.add-modules', ['module' => $module]);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_module(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $portal = Modules::where('_id', $id)
                            ->update([
                                'name' => $request->name
                            ]);
        if($portal){
            return redirect(route('modulelist'))->with('success', 'Module updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_module($id)
    {
        if($id != ''){
            $deleteCus = Modules::where(['_id' => $id])
            ->update([
                'is_deleted' => 1
               
            ]);
            if($deleteCus){

                return back()->with('success', 'Module deleted successfully');
            }else{
                return back()->with('error','Module deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }

       public function buildModuleslist($parent, $module) {
		$html = "";
		if (isset($module['parent_modules'][$parent])) {
			$html .= '<ul>\n';
			foreach ($module['parent_modules'][$parent] as $mid) {
				if (!isset($module['parent_modules'][$mid])) {
					$html .= "<li>\n  <a href='" . $module['modules'][$mid]['name'] . "'>" . $module['modules'][$mid]['name'] . "</a>\n</li> \n";
				}
				if (isset($module['parent_modules'][$mid])) {
					$html .= "<li>\n  <a href='" . $module['modules'][$mid]['name'] . "'>" . $module['modules'][$mid]['name'] . "</a> \n";
					// $html .= $this->buildModules($mid, $module);
					$html .= "</li> \n";
				}
			}
			$html .= "</ul> \n";
		}
		return $html;
	}

}
