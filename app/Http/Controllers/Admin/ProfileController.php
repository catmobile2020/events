<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use UploadImage;

    public function index()
    {
        $user = auth()->user()->user;
       return view('admin.pages.profile',compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $inputs = $request->except('photo');
        $inputs['username']=str_replace(' ','-',$request->name).'_'.rand(000,999);
        $user = auth()->user()->user;
        if ($request->has('password') and $request->get('password') !== null)
        {
            if (Hash::check($request->current_password,$user->password))
            {
                if ($request->current_password === $request->password)
                {
                    return redirect()->back()->with('message','same password');
                }
                $inputs['password']=$request->password;
            }
            return redirect()->back()->with('message','current password is Wrong Try Again');
        }
        $user->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$user,null,true);
        return redirect()->back()->with('message','Done Successfully');
    }
}
