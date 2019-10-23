<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;

class EventController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events",
     *      summary="Get events",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        if (request()->hasHeader('type') and request()->header('type') == 2)
        {
            $events = Event::available()->with('user','activeSpeakers')->paginate(5);
            return EventsResource::collection($events);
        }
        $event = auth()->user()->event;
        return EventResource::make($event);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/{event}",
     *      summary="Get event",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="event",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @return EventResource
     */
    public function show(Event $event)
    {
        if ($event->active)
            return EventResource::make($event);
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

}
