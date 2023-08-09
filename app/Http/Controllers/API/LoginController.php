<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Str;

class LoginController extends Controller
{
    /**
     * User login API method
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'username'    => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
           
            $success['name']  = $user->firstname.' '.$user->lastname;
            $success['username']  = $user->username;
            $success['email']  = $user->email;
            $success['sms']  = $user->smsnumber;
            $success['status']  = $user->status;
            $success['token'] = $this->generateToken();

            return sendResponse($success, 'You are successfully logged in.');
        } else {
            return sendError('Wrong username or password!', 401);
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return sendResponse([], 'You are successfully logged out.');
        
        }
    }


    public function generateToken(){
       return  Str::random(32).Auth::User()->id;
    }


}