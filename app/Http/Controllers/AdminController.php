<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Models\User;
use DB;
use Carbon\Carbon;
use DataTables;
use App\Models\Companies;
use App\Models\Projects;
use App\Models\Portals;

class AdminController extends Controller
{
    //

    public function admin_login()
    {
        return view('adminlogin');
    }

    public function admin_postLogin(Request $request)
    { 
        // echo Hash::make($request->password); die;
        $fields = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($fields->fails()) {
           
            return back()->with('error',$fields->errors());       
        }
     
        $user = User::where(['email' => $request->email, 'is_admin'=>1])->first();
   
        if ($user && Hash::check($request->password, $user->password)) {
       
            return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
        }else{
            return back()->with('error','Whoops! invalid email and password.');
        }

    }

    public function admin_dashboard()
    {
        $data['companyCount'] = Companies::count();
        $data['projectCount'] = Projects::count();
        $data['portals'] = Portals::count();
        $data['users'] = User::where('is_admin', '=', 0)->count();
        return view('dashboard')->with($data);

    }

    public function dms_companies()
    {
        $data =[];
        return view('dms-companies')->with($data);

    }

}