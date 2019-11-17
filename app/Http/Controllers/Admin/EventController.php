<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Partnership;
use App\Sponsor;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use UploadImage;

    public function index(Request $request)
    {
        $user= auth('web')->user();
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
        $user= auth('web')->user();
        $sponsors = $user->sponsors()->active()->get();
        $partnerships = $user->partnerships()->active()->get();
        return view('admin.pages.event.form',compact('event','sponsors','partnerships'));
    }


    public function store(EventRequest $request)
    {
        $inputs = $request->all();
        $inputs['invitation_code'] = rand(000000,999999);
        $user= auth('web')->user();
        $event = $user->events()->create($inputs);
        $event->sponsors()->attach($request->sponsor_ids);
        $event->partnerships()->attach($request->partnership_ids);
        $this->upload($request->logo,$event,'logo');
        $this->upload($request->cover,$event,'cover');
        return redirect()->route('admin.events.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Event $event)
    {
        $user= auth('web')->user();
        $sponsors = $user->sponsors()->active()->get();
        $partnerships = $user->partnerships()->active()->get();
        return view('admin.pages.event.form',compact('event','sponsors','partnerships'));
    }


    public function update(EventRequest $request, Event $event)
    {
        $inputs = $request->all();
        $event->update($inputs);
        $event->sponsors()->sync($request->sponsor_ids);
        $event->partnerships()->sync($request->partnership_ids);
        if ($request->logo)
            $this->upload($request->logo,$event,'logo',true);
        if ($request->cover)
            $this->upload($request->cover,$event,'cover',true);
        return redirect()->route('admin.events.index')->with('message','Done Successfully');
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('message','Done Successfully');
    }

    public function feedback(Event $event)
    {
        $rows = $event->feedback()->latest()->paginate(20);
        return view('admin.pages.event.feedback',compact('rows'));
    }

    public function analysis(Event $event)
    {
       $num_attendees = count($event->users);
       $num_speakers = count($event->speakers);
       $num_active_speakers = count($event->activeSpeakers);
       $num_talks = count($event->talks);
       $num_sponsors = count($event->activeSponsors);
       $num_partnerships = count($event->activePartnerships);
       $num_posts = count($event->posts);
       $num_comments = count($event->comments);
       $num_feedback = count($event->feedback);
       $num_testimonials = count($event->testimonials);
       $num_polls = count($event->polls);
       $num_questions = count($event->questions);
        return view('admin.pages.event.analysis',compact(
            'event','num_attendees','num_speakers','num_active_speakers','num_talks','num_sponsors',
            'num_partnerships','num_posts','num_comments','num_feedback','num_polls','num_testimonials','num_questions'
        ));
    }
}
