<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TalkRequest;
use App\Speaker;
use App\Talk;

class TalkController extends Controller
{
    public function index(Event $event)
    {
        $rows = $event->talks()->paginate(20);
        return view('admin.pages.talk.index',compact('rows','event'));
    }


    public function create(Event $event)
    {
        $talk = new Talk();
        $speakers = Speaker::all();
        return view('admin.pages.talk.form',compact('talk','event','speakers'));
    }


    public function store(Event $event,TalkRequest $request)
    {
        $inputs = $request->all();
        $event->talks()->create($inputs);
        return redirect()->route('admin.talks.index',$event->id)->with('message','Done Successfully');
    }


    public function show(Event $event,$id)
    {

    }


    public function edit(Event $event,Talk $talk)
    {
        $speakers = Speaker::all();
        return view('admin.pages.talk.form',compact('talk','event','speakers'));
    }


    public function update(Event $event,TalkRequest $request, Talk $talk)
    {
        $inputs = $request->except('password');
        if ($request->password != null)
        {
            $inputs['password']=$request->password;
        }
        $talk->update($inputs);
        return redirect()->route('admin.talks.index',$event->id)->with('message','Done Successfully');
    }


    public function destroy(Event $event,Talk $talk)
    {
        $talk->delete();
        return redirect()->route('admin.talks.index',$event->id)->with('message','Done Successfully');
    }

    public function feedback(Event $event,Talk $talk)
    {
        $rows = $talk->feedback()->latest()->paginate(20);
        return view('admin.pages.event.feedback',compact('rows'));
    }

    public function deleteFeedback(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('message','Done Successfully');
    }
}
