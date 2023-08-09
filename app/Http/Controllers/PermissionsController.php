<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Permissions;
use App\Models\Projects;
use App\Models\Portals;
use App\Models\Roles;
use App\Models\Modules;
use App\Models\userPortal;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PermissionsController extends Controller
{
    //
    public function permission_list()
    {
        $data['permissions'] = Permissions::with('project','portal','role')->where('is_deleted', 0)->get();
       
        return view('permissions.permissions-list')->with($data);

    }

    public function add_permission()
    {   
        $data['projectlist'] = Projects::where(['is_deleted' => 0])->get();

        $data['roles'] = Roles::where('is_deleted', 0)->get();
        $data['portals'] = Portals::where('is_deleted', 0)->get();
        $moduleslist = Modules::where('is_deleted', 0)->get();
        $module = array(
            'modules' => array(),
            'parent_modules' => array()
        );

        foreach($moduleslist as $row){
            //creates entry into modules array with current module id ie. $module['modules'][1]
            $module['modules'][$row['id']] = $row;
            //creates entry into parent_modules array. parent_modules array contains a list of all modules with children
            $module['parent_modules'][$row['module_id']][] = $row['id'];
        } 

        $data['module'] =  $this->buildModules(0,$module,0); 
       
        return view('permissions.add-permissions')->with($data);
    }

    public function postadd_permission(Request $request){
        // echo "<pre>"; print_r($request->all()); die;
        $fields = Validator::make($request->all(),[
            'projects' => 'required|string',
            'role' => 'required|array',
            'portal' => 'required|array',
            'modules' => 'required|array',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }
        
        $customModules = [];
        foreach($request->portal as $key => $row){
            
            foreach($request->modules[$key] as $keys => $rows){
                if($rows != 'on'){
                    $dataArr = [
                        'module' => $keys,
                        'access' => $rows
                    ];

                    array_push($customModules,$dataArr);
                }
             
            }
           
            $permission = new Permissions();
            $permission->project_id = $request->projects;
            $permission->portal_id = $row;
            $permission->role_id = $request->role[$key];
            $permission->module_permissions = json_encode($customModules);
            $permission->is_deleted = 0;
            $permission->created_at = now();
            $permission->save();
                
        }

        if($permission){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
        
    }


    public function edit_permission(Request $request)
    {   
        if(!empty($request->id)){
            $data['projectlist'] = Projects::where(['is_deleted' => 0])->get();
            $data['permissions'] = Permissions::where(['_id' => $request->id])->first();
           
            return view('permissions.edit-permissions')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_permission(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'projects' => 'required|string',
            'role' => 'required|array',
            'portal' => 'required|array',
            'modules' => 'required|array',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $role = Permissions::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                           ]);
        $customModules = [];
        foreach($request->portal as $key => $row){
            
            foreach($request->modules[$key] as $keys => $rows){
                if($rows != 'on'){
                    $dataArr = [
                        'module' => $keys,
                        'access' => $rows
                    ];

                    array_push($customModules,$dataArr);
                }
            
            }
            
            $permission = Permissions::where('_id', $id)
            ->update([
                'project_id' => $request->projects,
                'portal_id' => $row,
                'role_id' => $request->role[$key],
                'module_permissions' => json_encode($customModules),
                'updated_at' => now(),
            ]);

        }

        if($permission){
            
            return redirect(route('permissionlist'))->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
       
    }

    public function delete_permission($id)
    {

        if($id != ''){
            $deleteCus = Permissions::where(['_id' => $id])
            ->update([
                'is_deleted' => 1,
            ]);
            if($deleteCus){

                return back()->with('success', 'Permission deleted successfully');
            }else{
                return back()->with('error','Permission deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }

    public function buildModules($parent, $module, $indexes) {

		$html = "";
        $classSet = "";
		if (isset($module['parent_modules'][$parent])) {
			$html .= '<ul class="toggle-block">';
			foreach ($module['parent_modules'][$parent] as $key => $mid) {
                if($parent == 0){ $classSet = 'CheckAllbox'; }
				if (!isset($module['parent_modules'][$mid])) {
                        
                    $html .= '<li>
                                <span class="cart-arrow-down">
                                    <img src="'.asset('backend/assets/images/arrow-down.png').'" alt="">
                                </span>
                                <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].']" class="test '.$classSet.'">
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'">'.$module['modules'][$mid]['name'].'</label>
                                </div>
                                <ul class="toggle-block">
                                <li>
                                  <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'-add" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].'][add]" >
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'-add">Add</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'-edit" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].'][edit]" >
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'-edit">Edit</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'-delete" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].'][delete]" >
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'-delete">Delete</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'-view" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].'][view]" >
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'-view">View</label>
                                  </div>
                                </li>
                              </ul>';                        
				}

				if (isset($module['parent_modules'][$mid])) {
					$html .= '<li>
                                <span class="cart-arrow-down">
                                    <img src="'.asset('backend/assets/images/arrow-down.png').'" alt="">
                                </span>
                                <div class="form-group">
                                    <img class="folder-img" src="'.asset('backend/assets/images/icons8-folder.svg').'" alt="">
                                    <input type="checkbox" id="'.$module['modules'][$mid]['id'].$indexes.'" name="modules['.$indexes.']['.$module['modules'][$mid]['id'].']" class="test '.$classSet.'">
                                    <label class="bugs" for="'.$module['modules'][$mid]['id'].$indexes.'">'.$module['modules'][$mid]['name'].'</label>
                                </div>';
					$html .= $this->buildModules($mid, $module, $indexes);
					$html .= "</li> \n";
				}
			}
			$html .= "</ul> \n";
		}
		return $html;
	}

    public function get_projectportal(Request $request)
    {   
        $data = Portals::where(['project_id' => $request->proj_id])->get();    
       
        return $data;
    }

    public function get_roles_permission(Request $request)
    {   
        $data['role'] = Roles::where('is_deleted', 0)->get();
        $moduleslist = Modules::where('is_deleted', 0)->get();
        $module = array(
            'modules' => array(),
            'parent_modules' => array()
        );

        foreach($moduleslist as $row){
            //creates entry into modules array with current module id ie. $module['modules'][1]
            $module['modules'][$row['id']] = $row;
            //creates entry into parent_modules array. parent_modules array contains a list of all modules with children
            $module['parent_modules'][$row['module_id']][] = $row['id'];
        } 

        $data['module'] =  $this->buildModules(0,$module,$request->indexes);
        return $data;
    }
}
