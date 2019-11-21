<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\SponsorRequest;
use App\Sponsor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SponsorController extends Controller
{
    use UploadImage;

    public function __construct()
    {
        $this->middleware('permission:sponsors');
    }

    public function index(Request $request)
    {
        $user= auth()->user();
        if ($request->ajax())
        {
            $sponsor = Sponsor::findOrfail($request->id);
            $sponsor->update(['active'=>$request->active]);
            return 'Change Successfully To '.$sponsor->active_name;
        }
        $rows = $user->sponsors()->latest()->paginate(20);
        return view('admin.pages.sponsor.index',compact('rows'));
    }

    public function create()
    {
        $sponsor = new Sponsor;
        return view('admin.pages.sponsor.form',compact('sponsor'));
    }


    public function store(SponsorRequest $request)
    {
        $user= auth()->user();
        $inputs = $request->except('photo');
        $sponsor = $user->sponsors()->create($inputs);
        $this->upload($request->photo,$sponsor);
        return redirect()->route('admin.sponsors.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Sponsor $sponsor)
    {
        return view('admin.pages.sponsor.form',compact('sponsor'));
    }


    public function update(SponsorRequest $request, Sponsor $sponsor)
    {
        $inputs = $request->except('photo');
        $sponsor->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$sponsor,null,true);
        return redirect()->route('admin.sponsors.index')->with('message','Done Successfully');
    }


    public function destroy(Sponsor $sponsor)
    {
        $sponsor->trash();
        return redirect()->route('admin.sponsors.index')->with('message','Done Successfully');
    }
}
