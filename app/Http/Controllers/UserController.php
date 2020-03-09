<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function index(Request $request)
    {   

        if (session()->has('loggedInUser')) {
            return redirect('/dashboard')->with(['current_user'=>session("current_user")]);    
        } else {
            return view('login');
        }
        
    }

    public function authenticateUser(Request $request)
    {

        $parameters = $request->post();
        $users = User::where(['username'=>$parameters['userEmail'],'password'=>$parameters['userPassword']])->first();
        if ($users != null) {
            # code...
                if ($users->username == $parameters['userEmail'] && $users->password == $parameters['userPassword']) {
                    $current_user = [
                        "username"=>$users->username,
                        'name'=>$users->name,
                        'accessLevelId'=>$users->accessLevelId,
                        'accessLevelCode'=> AccessLevelController::checkAccessLevel($users->accessLevelId),
                        'id'=>$users->id
                    ];


                    session()->put('current_user',$current_user);
                    
                    session()->put('loggedInUserId',$current_user['id']);
                    session()->put('loggedInUserName',$current_user['username']);
                    session()->put('loggedInUserAccessLevelId',$current_user['accessLevelId']);
                    session()->put('loggedInUserAccessLevelCode',$current_user['accessLevelCode']);

                    // $request->session()->put("current_user",$current_user);
                    return redirect('/dashboard')->with('current_user',$current_user);
                    // return var_dump(session('current_user'));
                }else{
                    return back()->withErrors(['msg'=>"An unknown error occured. Please try again later." . $users]);
                }
            }else{
                return back()->withErrors(['msg'=>"Login Failed. Either your username or password is incorrect." . $users]);
        }
    }


    public static function checkLoggedIn()
    {
        $checkParameters = [    
            session()->has('loggedInUserId'),
            session()->has('loggedInUserName'),
            session()->has('loggedInUserAccessLevelId'),
            session()->has('loggedInUserAccessLevelCode')
        ];

        
        foreach ($checkParameters as $param) {
            if (!$param) {
                return false;
            }
        }

        return true;
    }


    public function logoutUser(Request $request)
    {
        UserController::logout();
        return redirect('/');
    }

    public static function logout()
    {
        session()->forget('current_user');
        session()->forget('loggedInUserId');
        session()->forget('loggedInUserName');
        session()->forget('loggedInUserAccessLevelId');
        session()->forget('loggedInUserAccessLevelCode');
        session()->flush();
    }
    
}
