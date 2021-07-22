<?php

namespace App\Http\Controllers;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function get_login() {
        if(!Auth::check())
                return view('cms.login');
            else
                return redirect('/home');
    }

    public function login(){

        //validate user's input
        $this->validate(request(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = request('email');
        $password = request('password');


        //select user only from users having 'admin' role
        $user = User::where('email',$email)->whereHas('roles', function($q){
            $q->where('name', 'cms_user');
        })->first();


        if($user == null){
            return view('cms.login')->withErrors('Wrong Email/Password!');
        }


        if( !Auth::attempt(['email' => $email , 'password' => $password]) ) {
            // Authentication not passed...
            return view('cms.login')->withErrors('Wrong Email/Password!');
        }


        // Authentication  passed...
        return redirect()->route('cms-home');

    }

    public function home(){
        return view('cms.home');
    }

    public function get_forgot_password(){
        return view('cms.forgot');
    }

    public function forgot_password(Request $request){

            //validate email and make sure it is for cms user
            $this->validate($request,[
                'email' => 'required|email',
            ]);

            $user = User::where('email',$request->email)->whereHas('roles', function($q){
                $q->where('name', 'cms_user');
            })->first();


            if($user){

                //generate a token and insert it into password_resets table,then send it by email  to the user
                $token = str_random(64);

                DB::table('password_resets')->insert(
                    ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
                );

                Mail::send(array(),['token' => 'tokenexample'], function($message) use($request,$token){
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');
                    $message->setbody("Hello, <br>
                                   There was a request to change your password!  <br>
                                   If you did not make this request then please ignore this email.  <br>
                                   Otherwise, please click <a href='" . route('get-cms-reset-password',$token) . "'>here</a> to change your password.", 'text/html');
                });

                return back()->with('success', 'We have e-mailed your password reset link!');
            }

        return redirect()->route('get-cms-forgot-password')->withErrors('Invalid Email !');

    }

    public function get_reset_password($token){

        //validate token and its size
        $validator = Validator::make(['token' => $token], [
            'token' => 'required|string|size:64',
        ]);
        if (!$validator->fails())
            return view('cms.reset')->with('token',$token);
        return redirect()->route('get-cms-forgot-password')->withErrors('Invalid Token !');
    }

    public function reset_password(Request $request){
        //validate user input
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required',
            'reset_token' => 'required|string|size:64',
        ]);


        //check if user exists and is a cms user
        $user = User::where('email',$request->email)->whereHas('roles', function($q){
            $q->where('name', 'cms_user');
        })->first();

        //check if this token exists,was created in the last 10 minutes, and it is  for this user
        $canChangePassword = DB::table('password_resets')
            ->where('token','=',$request->reset_token)
            ->where('email','=',$request->email)
            ->where('created_at','>',Carbon::now()->subMinutes(10))
            ->first();

        if($user){
            if($canChangePassword){
                //remove the token from password_resets  table (so it can be used once), then change user's password
                DB::table('password_resets')
                    ->where('token','=',$request->reset_token)
                    ->where('email','=',$request->email)
                    ->where('created_at','>',Carbon::now()->subMinutes(10))
                    ->delete();

                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->route('get-cms-login')->with('success','Your password has been changed!, please Login');
            }

            // invalid/expired token
            return redirect()->route('get-cms-forgot-password')->withErrors('Invalid/Expired Token !');
        }

        //invalid user
        return redirect()->route('get-cms-forgot-password')->withErrors('Invalid Email !');

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('get-cms-login')->with('success','Logged out successfully');
    }
}
