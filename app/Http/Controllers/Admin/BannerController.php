<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\BannerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    use UploadImage;

    public function index(Request $request)
    {
        $rows = Banner::latest()->paginate(20);
        return view('admin.pages.banner.index',compact('rows'));
    }

    public function create()
    {
        $banner = new Banner;
        return view('admin.pages.banner.form',compact('banner'));
    }


    public function store(BannerRequest $request)
    {
        $inputs = $request->except('photo');
        $banner = Banner::create($inputs);
        $this->upload($request->photo,$banner);
        return redirect()->route('admin.banners.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Banner $banner)
    {
        return view('admin.pages.banner.form',compact('banner'));
    }


    public function update(BannerRequest $request, Banner $banner)
    {
        $inputs = $request->except('photo');
        $banner->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$banner,null,true);
        return redirect()->route('admin.banners.index')->with('message','Done Successfully');
    }


    public function destroy(Banner $banner)
    {
        $banner->trash();
        return redirect()->route('admin.banners.index')->with('message','Done Successfully');
    }
}
