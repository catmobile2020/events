<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Events\ChatEvent;
use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/{event}/chat",
     *      summary="Get event chat message",
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
    public function chat(Event $event)
    {
        return ChatResource::collection($event->messages()->with('chatable')->get());
    }


    /**
     *
     * @SWG\Post(
     *      tags={"events"},
     *      path="/events/{event}/chat",
     *      summary="add send message",
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
     *         name="message",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Request $request
     * @param Event $event
     * @return ChatResource
     */
    public function sendMessage(Request $request,Event $event)
    {
        $user = auth()->user();
        $message = $user->chat()->create([
            'message'=>$request->message,
            'event_id'=>$event->id
        ]);
        $message->chatable;
        $message = ChatResource::make($message);
        broadcast(new ChatEvent($message));
        return $message;
    }
}
