<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Resources\TestimonialResource;
use App\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"testimonials"},
     *      path="/events{event}/testimonials",
     *      summary="Get event testimonials",
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
        $testimonials = $event->activeTestimonials()->paginate(5);
        return TestimonialResource::collection($testimonials);
    }
}
