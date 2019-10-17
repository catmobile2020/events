<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        $rows = User::where('type',1)->paginate(20);
        return view('admin.pages.user.index',compact('rows'));
    }


    public function create()
    {
        $user = new User;
        return view('admin.pages.user.form',compact('user'));
    }


    public function store(UserRequest $request)
    {
        $inputs = $request->all();
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        User::create($inputs);
        return redirect()->route('admin.users.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(User $user)
    {
        return view('admin.pages.user.form',compact('user'));
    }


    public function update(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        User::create($inputs);
        return redirect()->route('admin.users.index')->with('message','Done Successfully');
    }


    public function destroy(User $user)
    {
        $user->trash();
        return redirect()->route('admin.users.index')->with('message','Done Successfully');
    }
}
