<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Requests\Api\FeedbackRequest;
use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\SpeakerResource;
use App\Speaker;
use App\Talk;

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

    /**
     *
     * @SWG\Post(
     *      tags={"events"},
     *      path="/events/{event}/join",
     *      summary="join event",
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
    public function joinToEvent(Event $event)
    {
        $user= auth()->user();
        if ($event->active)
        {
            if ($event->is_public)
            {
                if ($user->attendeeEvents()->find($event->id))
                {
                    return response()->json(['data'=>'You Already Joined'],200);
                }else
                {
                    $user->attendeeEvents()->attach($event->id);
                    return response()->json(['data'=>'Join Successfully'],200);
                }
            }
            return response()->json(['data'=>"You can't Join To This Event . Its Private !"],402);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }


    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/{event}/feedback",
     *      summary="Get event feedback",
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function eventFeedback(Event $event)
    {
        if ($event->active)
        {
            $feedback = $event->feedback()->paginate();
            return FeedbackResource::collection($feedback);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"events"},
     *      path="/events/{event}/feedback",
     *      summary="add event feedback",
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
     *     @SWG\Parameter(
     *         name="note",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *     @SWG\Parameter(
     *         name="rate",
     *         in="formData",
     *         description="3/5",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function storeEventFeedback(Event $event,FeedbackRequest $request)
    {
        if ($event->active)
        {
            $feedback = $event->feedback()->create($request->all());
            return FeedbackResource::make($feedback);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/talks/{talk}/feedback",
     *      summary="Get talk feedback",
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
     *         name="talk",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Talk $talk
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function talkFeedback(Talk $talk)
    {
        $feedback = $talk->feedback()->paginate();
        return FeedbackResource::collection($feedback);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"events"},
     *      path="/events/talks/{talk}/feedback",
     *      summary="add talk feedback",
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
     *         name="talk",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="note",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *     @SWG\Parameter(
     *         name="rate",
     *         in="formData",
     *         description="3/5",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Talk $talk
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function storeTalkFeedback(Talk $talk,FeedbackRequest $request)
    {
        $feedback = $talk->feedback()->create($request->all());
        return FeedbackResource::make($feedback);
    }

}
