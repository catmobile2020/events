<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadImage;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    use UploadImage;

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $testimonial=Testimonial::findOrfail($request->id);
            $testimonial->update(['active'=>$request->active]);
            return 'Change Successfully To '.$testimonial->active_name;
        }
        $rows = Testimonial::latest()->paginate(20);
        return view('admin.pages.testimonial.index',compact('rows'));
    }

    public function create()
    {
        $testimonial = new Testimonial;
        return view('admin.pages.testimonial.form',compact('testimonial'));
    }


    public function store(TestimonialRequest $request)
    {
        $inputs = $request->except('photo');
        $testimonial = Testimonial::create($inputs);
        $this->upload($request->photo,$testimonial);
        return redirect()->route('admin.testimonials.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Testimonial $testimonial)
    {
        return view('admin.pages.testimonial.form',compact('testimonial'));
    }


    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $inputs = $request->except('photo');
        $testimonial->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$testimonial,null,true);
        return redirect()->route('admin.testimonials.index')->with('message','Done Successfully');
    }


    public function destroy(Testimonial $testimonial)
    {
        $testimonial->trash();
        return redirect()->route('admin.testimonials.index')->with('message','Done Successfully');
    }
}
