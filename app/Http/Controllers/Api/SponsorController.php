<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Resources\SponsorResource;
use App\Sponsor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SponsorController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"sponsors"},
     *      path="/events{event}/sponsors",
     *      summary="Get event sponsors",
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
        $sponsors = $event->activeSponsors()->paginate(5);
        return SponsorResource::collection($sponsors);
    }
}
