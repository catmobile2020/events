<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    use UploadImage;

    public function __construct()
    {
        $this->middleware('permission:testimonials');
    }

    public function index(Event $event,Request $request)
    {
        if ($request->ajax())
        {
            $testimonial=Testimonial::findOrfail($request->id);
            $testimonial->update(['active'=>$request->active]);
            return 'Change Successfully To '.$testimonial->active_name;
        }
        $rows = $event->testimonials()->paginate(20);
        return view('admin.pages.testimonial.index',compact('rows','event'));
    }

    public function create(Event $event)
    {
        $testimonial = new Testimonial;
        return view('admin.pages.testimonial.form',compact('testimonial','event'));
    }


    public function store(Event $event,TestimonialRequest $request)
    {
        $inputs = $request->except('photo');
        $testimonial = $event->testimonials()->create($inputs);
        $this->upload($request->photo,$testimonial);
        return redirect()->route('admin.testimonials.index',$event->id)->with('message','Done Successfully');
    }


    public function show(Event $event,$id)
    {

    }


    public function edit(Event $event,Testimonial $testimonial)
    {
        return view('admin.pages.testimonial.form',compact('testimonial','event'));
    }


    public function update(Event $event,TestimonialRequest $request, Testimonial $testimonial)
    {
        $inputs = $request->except('photo');
        $testimonial->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$testimonial,null,true);
        return redirect()->route('admin.testimonials.index',$event->id)->with('message','Done Successfully');
    }


    public function destroy(Event $event,Testimonial $testimonial)
    {
        $testimonial->trash();
        return redirect()->route('admin.testimonials.index',$event->id)->with('message','Done Successfully');
    }
}
