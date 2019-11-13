<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\MessageRequest;
use App\Http\Requests\Api\RoomRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\RoomResource;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"messenger"},
     *      path="/rooms",
     *      summary="user rooms",
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
    public function messenger()
    {
        $user = auth()->user();
        $rooms = Room::where('roomable_id',$user->id)->orWhere('receive__id',$user->id)->get();
        return RoomResource::collection($rooms);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"messenger"},
     *      path="/rooms",
     *      summary="Create New Room",
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
     *         name="receive__id",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="user_type",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         description="attendee , speaker",
     *         format="string",
     *         default="attendee",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param RoomRequest $request
     * @return RoomResource
     */
    public function createRoom(RoomRequest $request)
    {
        $user = auth()->user();
        if (
            $user->messenger()->where('receive__id',$request->receive__id)->where('user_type',$request->user_type)->first() or
            Room::where('receive__id',$user->id)->first()
        )
        {
            return response()->json(['data'=>'You Have Room With Person Already'],200);
        }
        $room = $user->messenger()->create([
            'receive__id'=>$request->receive__id,
            'user_type'=>$request->user_type,
        ]);
        return RoomResource::make($room);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"messenger"},
     *      path="/rooms/{room}/send-message",
     *      summary="send message",
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
     *         name="room",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Room $room
     * @param MessageRequest $request
     * @return MessageResource
     */
    public function sendMessage(Room $room,MessageRequest $request)
    {
        $user = auth()->user();
        $message = $user->messages()->create([
            'body'=>$request->body,
            'room_id'=>$room->id,
        ]);
        return MessageResource::make($message);
    }
}
