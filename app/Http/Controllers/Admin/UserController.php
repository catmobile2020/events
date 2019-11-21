<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

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
        $permissions = Permission::all();
        return view('admin.pages.user.form',compact('user','type','permissions'));
    }


    public function store($type,UserRequest $request)
    {
        $inputs = $request->all();
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        $inputs['type']=$type;
        $user = User::create($inputs);
        $user->givePermissionTo($request->permissions);
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }


    public function show($type,$id)
    {

    }


    public function edit($type,User $user)
    {
        $permissions = Permission::all();
        return view('admin.pages.user.form',compact('user','type','permissions'));
    }


    public function update($type,UserRequest $request, User $user)
    {
        $inputs = $request->all();
//        dd($request->permissions);
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        $inputs['type']=$type;
        $user->update($inputs);
        $user->syncPermissions($request->permissions);
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }


    public function destroy($type,User $user)
    {
        $user->trash();
        $user->permissions()->delete();
        return redirect()->route('admin.users.index',$type)->with('message','Done Successfully');
    }
}
