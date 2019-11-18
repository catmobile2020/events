<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Requests\Admin\TicketRequest;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index(Event $event,Request $request)
    {
        if ($request->ajax())
        {
            $ticket=Ticket::findOrfail($request->id);
            $ticket->update(['active'=>$request->active]);
            return 'Change Status Successfully';
        }
        $rows = $event->tickets()->paginate(20);
        return view('admin.pages.event.ticket',compact('event','rows'));
    }

    public function store(TicketRequest $request,Event $event)
    {
        for($i=0;$i<$request->count_number;$i++)
        {
            $code = $event->id.rand(00000,9999);
            $event->tickets()->create(['code'=>$code]);
        }
        return redirect()->back();
    }
}
