<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Requests\Api\PollRequest;
use App\Http\Resources\PollResource;
use App\Http\Resources\VoteResource;
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
                return  PollResource::make($poll);
            }
            return response()->json(['data'=>'You Mast Be Speaker'],402);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"polls"},
     *      path="/events/{event}/polls/add-vote",
     *      summary="Add vote in Poll",
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
     *         name="option_id",
     *         in="formData",
     *         required=true,
     *         type="integer",
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
     * @param PollRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVote(Event $event,Request $request)
    {
        if ($event->active)
        {
            $user= auth()->user();
//            return response()->json(['data'=>$user],402);
            $poll = $user->options()->sync($request->only(['option_id','notes']));
            return  VoteResource::make($poll);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }
}
