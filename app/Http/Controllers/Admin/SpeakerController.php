<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Requests\Admin\SpeakerRequest;
use App\Speaker;
use App\Http\Controllers\Controller;

class SpeakerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:speakers');
    }

    public function index(Event $event)
    {
        $rows = $event->speakers()->paginate(20);
        return view('admin.pages.speaker.index',compact('rows','event'));
    }


    public function create(Event $event)
    {
        $speaker = new Speaker();
        return view('admin.pages.speaker.form',compact('speaker','event'));
    }


    public function store(Event $event,SpeakerRequest $request)
    {
        $inputs = $request->all();
        $event->speakers()->create($inputs);
        return redirect()->route('admin.speakers.index',$event->id)->with('message','Done Successfully');
    }


    public function show(Event $event,$id)
    {

    }


    public function edit(Event $event,Speaker $speaker)
    {
        return view('admin.pages.speaker.form',compact('speaker','event'));
    }


    public function update(Event $event,SpeakerRequest $request, Speaker $speaker)
    {
        $inputs = $request->except('password');
        if ($request->password != null)
        {
            $inputs['password']=$request->password;
        }
        $speaker->update($inputs);
        return redirect()->route('admin.speakers.index',$event->id)->with('message','Done Successfully');
    }


    public function destroy(Event $event,Speaker $speaker)
    {
        $speaker->trash();
        return redirect()->route('admin.speakers.index',$event->id)->with('message','Done Successfully');
    }
}
