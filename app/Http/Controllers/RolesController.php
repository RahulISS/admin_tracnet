<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RolesController extends Controller
{
    //
    public function role_list()
    {
        $data['roles'] = Roles::where('is_deleted', 0)->get();
       
        return view('roles.roles-list')->with($data);

    }

    public function add_role()
    {
        return view('roles.add-roles');
    }

    public function postadd_role(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $portal = new Roles();
        $portal->name = $request->name;
        $portal->is_deleted = 0;
        $portal->created_at = now();
        $portal->save();

        if($portal){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_role(Request $request)
    {   
        if(!empty($request->id)){
            $data['role'] = Roles::where(['_id' => $request->id])->first();
           
            return view('roles.add-roles')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_role(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $role = Roles::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                            ]);
        if($role){
            return redirect(route('rolelist'))->with('success', 'Role updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_role($id)
    {
        if($id != ''){
            $deleteCus = Roles::where(['_id' => $id])
            ->update([
                'is_deleted' => 1,
            ]);
            if($deleteCus){

                return back()->with('success', 'Role deleted successfully');
            }else{
                return back()->with('error','Role deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }
}
