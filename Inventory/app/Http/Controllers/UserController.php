<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Mockery\Expectation;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{

    function LoginPage():View{
        return view('pages.auth.login-page');   
     }
    function RegistrationPage():View{
        return view('pages.auth.registration-page');   
     }
    function SendOtpPage():View{
        return view('pages.auth.sand-otp-page');   
     }
    function VerifyOTPPage():View{
        return view('pages.auth.verify-otp-page');   
     }
    function ResetPasswordPage():View{
        return view('pages.auth.reset-pass-page');   
     }

    function userLogin(Request $request){
            $count = User::where('email', "=", $request->input('email'))
            ->where('password', "=", $request->input('password'))
            ->count() ;

            if ($count == 1){

                //token create and user issued
                $token = JWTToken::createJWTToken($request->input('email'));
                return response()->json(['status' =>'Succes', 'message' =>'User Login Success'], 200)->cookie('token', $token, 60*60*24);
            }
        else {
            return response()->json([
                'status'=> "failed",
                'message' =>'unthurized'
                
            ], 401);
        }
    }
    function userRegister(Request $request){
        //return User::create($request->input());

        try {
            // Attempt to create a new user with the provided data
             User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'phone' => $request->input('mobile'),
                'password' => $request->input('password')
            ]); 
        
            // If user creation is successful, respond with a success message
            return response()->json([
                'status' => 'Success',
                'message' => 'User Registration Successful'
            ],200);
        } catch (\Exception $e) {
            // Something went wrong during user creation
            return response()->json([
                'status' => 'failed',
                'message' => 'Something Wrong'
            ], 400);
        }
    }
    function OTPToMail(Request $request){
        $UserMail = $request->input('email');
        $otp = rand(100000, 999999);

        //mail chaeck method
        $res = User::where($request->input())->count();
        if ($res == 1) {

            //mail sent method
            Mail::to($UserMail)->send(new OTPMail($otp));

            //database update by otp
            User::where($request->input())->update(['otp'=>$otp]);
            return response()->json(['status' =>'Succes', 'message'=>'Otp sent to you mail'],200);
        }else{

            return response()->json([
                'status' =>'Faild',
                'message' => 'unthurized'
            ],400);
        }
    }
    function OTPVarified(Request $request){
        $res = User::where('otp', $request->input('otp'))->count();
    
        if ($res == 1) {
            User::where('otp', $request->input('otp'))->update(['otp' => "0"]);
            return response()->json(['status' => 'Success', 'message' => 'Verified', redirect()->route('route.name')]);
        
        } else {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized']);
        }
    }
    function setPassword(Request $request){
        // $pass = $request->input('password');
        // User::where($request->input())->update(['password'=>$pass ]);
        // return response()->json(['msg' =>'Succes', 'data'=>'Updated']);

        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            // Remove Cookie...
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],400);
        }
    }
    function profileUpdate(){
    
    }

    
}