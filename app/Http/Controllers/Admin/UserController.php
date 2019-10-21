<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index($type)
    {
        $rows = User::where('type',$type)->paginate(20);
        return view('admin.pages.user.index',compact('rows'));
    }


    public function create($type)
    {
        $user = new User;
        return view('admin.pages.user.form',compact('user','type'));
    }


    public function store($type,UserRequest $request)
    {
        $inputs = $request->all();
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        $inputs['type']=$type;
        User::create($inputs);
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }


    public function show($type,$id)
    {

    }


    public function edit($type,User $user)
    {
        return view('admin.pages.user.form',compact('user','type'));
    }


    public function update($type,UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        $inputs['type']=$type;
        $user->update($inputs);
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }


    public function destroy($type,User $user)
    {
        $user->trash();
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }
}
