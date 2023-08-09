<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    //

    /**
     * Admin Login
     */
    public function login(){

        return view('adminlogin');

    }


    /**
     * Admin login function
     * @var $request
     */
    public function handleLogin(Request $request)
    {
        // dd($request->username);
        // $request->validate([
        //     'username' => 'required|username',
        //     'password' => 'required',
        // ]);
        

        $validUser=User::where(['username' => $request->username, 'is_admin'=>1])->exists();
       if(! $validUser){
          return back()->with('error','Whoops! invalid username and password.');
       }
  
   
        if(Auth::attempt(['username' => $request->input('username'),  'password' => $request->input('password')])){
                return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
        }else {
            return back()->with('error','Whoops! invalid email and password.');
        }
    }

    public function adminLogout (Request $request){
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }


}
