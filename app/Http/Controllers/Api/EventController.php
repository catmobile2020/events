<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;
use App\Http\Resources\SpeakerResource;
use App\Speaker;

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
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee , 2=> speaker",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
       if (request()->header('type') == 1)
       {
           $events = Event::available()->latest()->with('user','activeSpeakers')->paginate(5);
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
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee , 2=> speaker",
     *         format="integer",
     *      ),
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

    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/speakers/{speaker}",
     *      summary="Get single speaker",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee , 2=> speaker",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="speaker",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Speaker $speaker
     * @return EventResource|\Illuminate\Http\JsonResponse
     */
    public function singleSpeaker(Speaker $speaker)
    {
        if ($speaker->active)
            return SpeakerResource::make($speaker);
        return response()->json(['data'=>'Speaker is Not Active Yet !'],402);
    }

}
