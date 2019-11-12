<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Events\PollEvent;
use App\Events\VoteEvent;
use App\Http\Requests\Api\PollRequest;
use App\Http\Resources\OptionResource;
use App\Http\Resources\PollResource;
use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations as SWG;

class PollController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"polls"},
     *      path="/events/{event}/polls",
     *      summary="Get event polls",
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
    public function index(Event $event)
    {
        if ($event->active)
            return PollResource::collection($event->polls()->paginate(5));
        return response()->json(['data'=>'Event is Not Active Yet !'],402);

    }

    /**
     *
     * @SWG\Post(
     *      tags={"polls"},
     *      path="/events/{event}/polls",
     *      summary="Add new Poll To Event",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="only Spaker  2=> speaker",
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
     *         name="question",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *     @SWG\Parameter(
     *         name="answers[]",
     *         in="formData",
     *         required=true,
     *         type="array",
     *         @SWG\Items(
     *           type="string",
     *         ),
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param PollRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Event $event,PollRequest $request)
    {
        if ($event->active)
        {
            if (auth('speakers')->check() and request()->header('type') == 2)
            {
                $user= auth()->user();
                $poll = $user->polls()->create($request->all());
                foreach ($request->answers as $answer)
                    $poll->options()->create(['answer'=>$answer]);

                $resource_poll = PollResource::make($poll);
                broadcast(new PollEvent($resource_poll));
                return $resource_poll;
            }
            return response()->json(['data'=>'You Mast Be Speaker'],402);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"polls"},
     *      path="/events/{event}/polls/{option}/add-vote",
     *      summary="Add vote in Poll",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="only attendees  1=> attendee",
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
     *         name="option",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="notes",
     *         in="formData",
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param Option $option
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVote(Event $event,Option $option,Request $request)
    {
        if ($event->active)
        {
            $user= auth()->user();
            if ($user->options()->find($request->option_id))
            {
                $user->options()->detach($request->option_id);
            }
            $user->options()->attach($option->id,['notes'=>$request->notes]);

            broadcast(new VoteEvent(OptionResource::make($option)));
            return response()->json(['data'=>'send Successfully'],200);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }
}
