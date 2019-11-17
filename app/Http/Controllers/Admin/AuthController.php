<?php

namespace App\Http\Controllers\Admin;

use App\Attendee;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    public function index()
    {
     return view('admin.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->username;
//        $row = User::whereHas('user',function ($q) use ($username){
//            $q->where(function ($q) use ($username){
//                    $q->where('username',$username)->orWhere('email',$username);
//            });
//        })->first();

        $attendee = Attendee::where(function ($q) use ($username){
            $q->where('username',$username)->orWhere('email',$username);
        })->first();

        if ($attendee)
        {
            $row = $attendee->user;
            if (!in_array($row->type,[2,3]))
            {
                if ($row->active ==0)
                {
                    return redirect()->back()->with('message','Your Account Is DisActive Back To Admin');
                }
                if (Hash::check($request->password,$attendee->password))
                {
                    auth()->guard('web')->login($row,$request->remember);
                    return redirect()->intended('/');
                }
            }
        }
        return redirect()->back()->with('message','Error Your Credential is Wrong');
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
