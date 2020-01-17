<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function index()
    {   

        if (session()->has('current_user')) {
            return back()->with(['current_user'=>session("current_user")]);    
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

    public function logoutUser(Request $request)
    {
        if (session('current_user') != null) {
            session('current_user',null);
            $request->session()->forget('current_user');
        }
        return redirect('/');
    }
    
}
