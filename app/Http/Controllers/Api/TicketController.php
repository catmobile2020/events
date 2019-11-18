<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Requests\Api\TicketRequest;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    /**
     *
     * @SWG\Post(
     *      tags={"ticketing"},
     *      path="/events/{event}/booking-ticket",
     *      summary="booking event ticket",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="only attendee 1 => attendee",
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
     *         name="method_type",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         description="1=>cash  2=>credit",
     *         default="1",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param TicketRequest $request
     * @return TicketResource
     */
    public function booking(Event $event,TicketRequest $request)
    {
        if (request()->hasHeader('type') and request()->header('type') == 2)
        {
            return response()->json(['data'=>"User Type Wrong Try Again"],400);
        }

        if (!$event->have_ticket)
        {
            return response()->json(['data'=>"this event didn't Have Tickets"],200);
        }
       $user= auth()->user();
       if ($event->tickets()->where('user_id',$user->id)->first())
       {
           return response()->json(['data'=>'You Already Booking'],200);
       }
       $ticket = $event->tickets()->whereNull('user_id')->first();
       if (!$ticket)
       {
           return response()->json(['data'=>'Sorry All Tickets Already Booking'],200);
       }
       $ticket->update([
            'method_type'=>$request->method_type,
            'user_id'=>$user->id,
        ]);
       return TicketResource::make($ticket);
    }
}
