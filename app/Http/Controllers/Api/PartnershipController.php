<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Resources\PartnershipResource;
use App\Partnership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnershipController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"partnerships"},
     *      path="/events{event}/partnerships",
     *      summary="Get event partnerships",
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Event $event)
    {
        $sponsors = $event->activePartnerships()->paginate(5);
        return PartnershipResource::collection($sponsors);
    }
}
