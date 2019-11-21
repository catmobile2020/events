<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\PartnershipRequest;
use App\Partnership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnershipController extends Controller
{
    use UploadImage;

    public function __construct()
    {
        $this->middleware('permission:partnerships');
    }

    public function index(Request $request)
    {
        $user= auth()->user();
        if ($request->ajax())
        {
            $partnership=Partnership::findOrfail($request->id);
            $partnership->update(['active'=>$request->active]);
            return 'Change Successfully To '.$partnership->active_name;
        }
        $rows = $user->partnerships()->latest()->paginate(20);
        return view('admin.pages.partnership.index',compact('rows'));
    }

    public function create()
    {
        $partnership = new Partnership;
        return view('admin.pages.partnership.form',compact('partnership'));
    }


    public function store(PartnershipRequest $request)
    {
        $user= auth()->user();
        $inputs = $request->except('photo');
        $partnership = $user->partnerships()->create($inputs);
        $this->upload($request->photo,$partnership);
        return redirect()->route('admin.partnerships.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Partnership $partnership)
    {
        return view('admin.pages.partnership.form',compact('partnership'));
    }


    public function update(PartnershipRequest $request, Partnership $partnership)
    {
        $inputs = $request->except('photo');
        $partnership->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$partnership,null,true);
        return redirect()->route('admin.partnerships.index')->with('message','Done Successfully');
    }


    public function destroy(Partnership $partnership)
    {
        $partnership->trash();
        return redirect()->route('admin.partnerships.index')->with('message','Done Successfully');
    }
}
