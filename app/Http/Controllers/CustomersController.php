<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Roles;
use App\Models\userPortal;
use App\Models\Projects;
use App\Models\Portals;
use App\Models\Permissions;
use Illuminate\Support\Facades\DB;
use App\Models\userPermission;

class CustomersController extends Controller
{

    /**
     * User ajax list for datatables
     */

     public function userAjaxData(Request $request){
        if ($request->ajax()) {
            $data =  User::where('is_deleted', 0)->get();
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


    public function customer_list()
    {
        $data['customers'] = User::where('is_deleted', 0)->with('userPermission', 'userPermission.projects', 'userPermission.portals', 'userPermission.roles')->get();
        return view('customers.customers-list')->with($data);

    }

    public function add_customer()
    {
        // $data['roles'] = Roles::where('is_deleted', 0)->get();
        $data['projects'] = Projects::where('is_deleted', 0)->get();
        return view('customers.add-customers')->with($data);
    }

    public function postadd_customer(Request $request)
    {   
        $fields = Validator::make($request->all(),[
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|unique:username',
            'password' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        } 
        // echo"<pre>";   print_r($request->all()); die;
            $customer = new User();
            $customer->firstname = $request->firstname;
            $customer->lastname = $request->lastname;
            $customer->username = str_replace(' ','',strtolower($request->username));
            $customer->email = strtolower($request->email);
            $customer->smsnumber = $request->smsnumber;
            $customer->password = Hash::make($request->password);
            $customer->is_admin = 0;
            $customer->status = $request->status;
            $customer->is_deleted = 0;
            $customer->created_at = now();
      
            if($customer->save()) {  
                if(count($request->project) > 0 ) {
                    foreach ($request->project as $key => $value) {
                    
                        $portal = new userPermission();
                        $portal->user_id = $customer->_id;
                        $portal->project_id = $value;
                        $portal->portal_id = $request['multiple_portal'][$key]; 
                        $portal->role_id = $request['multiple_role'][$key];           
                        $portal->save();
                    }
                }   
            }
            
        return back()->with('success', 'Added Successfully'); 
        // } catch (\Exception $e) {
        //     return back()->with('error' , $e); 
        //     throw $e;
        // }
    }

    public function edit_customer(Request $request)
    {   
        if(!empty($request->id)){

            $customer = User::where(['_id' => $request->id])->first();
            $projects = Projects::where('is_deleted', 0)->get();
                      
            return view('customers.edit-customer', ['customer' => $customer,'projects' => $projects]);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_customer(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|unique:username',
            'password' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        } 
       
        $customer = User::where('_id', $id)
                            ->update([
                                'firstname' => $request->firstname,
                                'lastname' => $request->lastname,
                                'username' => str_replace(' ','',strtolower($request->username)),
                                'email' => strtolower($request->email),
                                'smsnumber' => $request->smsnumber,
                                'password' => Hash::make($request->password),
                                'status' => $request->status,
                                'updated_at' => now()
                            ]);
        if($customer){
            if(count($request->permissions) > 0 ) {
                foreach ($request->permissions as $key => $value) {
                    
                    $portal = userPermission::where(['user_id' => $customer->_id,'_id'=>$request->user_permission_id])->update([
                        'project_id' => $value['project'],
                        'portal_id' => $value['multiple_portal'],
                        'role_id' => $value['multiple_role']
                    ]);
       
                }
            } 
            
            return redirect(route('customerlist'))->with('success', 'User updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_customer($id)
    {
        if($id != ''){
            $deleteCus = User::where(['_id' => $id])
            ->update([
                'is_deleted' => 1,
                'updated_at' => now()
            ]);
            if($deleteCus){

                return back()->with('success', 'Customer deleted successfully');
            }else{
                return back()->with('error','Customer deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }

    public function get_portal(Request $request)
    {    
        $data = Portals::where(['project_id' => $request->project_id])->get();   
      
        return $data;
    }

    public function get_project(Request $request)
    {
        $data = Projects::where('is_deleted', 0)->get();
        return $data;
    }

    public function get_role(Request $request)
    {       
       
        $data = Permissions::where([
            'project_id' => $request->project_id,
            'portal_id' => $request->portal_id,
            ])->pluck('role_id')->toArray();
      
        $roles=Roles::whereIn('_id',$data)->get();
        
        return response()->json(['message'=>'success','data'=>$roles]);
    }

    public function view(Request $request)
    {
        try {
            if(isset($request)) {
                
                $data['customer'] = User::where(['_id' => $request->id])
                                    ->with('userPermission', 'userPermission.projects', 'userPermission.portals', 'userPermission.roles')
                                    ->first();
               // dd($data);
                return view('customers.view')->with($data);
            }
        }
        catch (exception $e) {
            return back()->with('error' , $e);
        }
    }
}
