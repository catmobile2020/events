<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use UploadImage;

    public function index(Request $request)
    {
        $user= auth()->user();
        if ($user->type == 0)
        {
            if ($request->ajax())
            {
                $event=Event::findOrfail($request->id);
                $event->update(['active'=>$request->active]);
                return 'Change Successfully To '.$event->active_name;
            }
            $rows = Event::latest()->paginate(20);
        }else
        {
            $rows = $user->events()->latest()->paginate(20);
        }
        return view('admin.pages.event.index',compact('rows'));
    }


    public function create()
    {
        $event = new Event;
        return view('admin.pages.event.form',compact('event'));
    }


    public function store(EventRequest $request)
    {
        $inputs = $request->all();
        $user= auth()->user();
        $event = $user->events()->create($inputs);
        $this->upload($request->logo,$event,'logo');
        $this->upload($request->cover,$event,'cover');
        return redirect()->route('admin.events.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Event $event)
    {
        return view('admin.pages.event.form',compact('event'));
    }


    public function update(EventRequest $request, Event $event)
    {
        $inputs = $request->all();
        $event->update($inputs);
        if ($request->logo)
            $this->upload($request->logo,$event,'logo',true);
        if ($request->cover)
            $this->upload($request->cover,$event,'cover',true);
        return redirect()->route('admin.events.index')->with('message','Done Successfully');
    }


//    public function destroy(Event $event)
//    {
//        $event->delete();
//        return redirect()->route('admin.events.index')->with('message','Done Successfully');
//    }
}
