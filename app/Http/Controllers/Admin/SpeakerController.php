<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Requests\Admin\SpeakerRequest;
use App\Speaker;
use App\Http\Controllers\Controller;
use App\User;

class SpeakerController extends Controller
{
    public function index(Event $event)
    {
        $rows = $event->speakers()->paginate(20);
//        dd($rows);
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
        $inputs['event_id'] = $event->id;
        $user =User::create(['type'=>2,'active'=>$request->active]);
        $user->user()->create($inputs);
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
        $speaker->delete();
        return redirect()->route('admin.speakers.index',$event->id)->with('message','Done Successfully');
    }
}
