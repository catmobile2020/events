<?php

namespace App\Http\Controllers\Api;

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
     *      path="/testimonials",
     *      summary="Get testimonials",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        $testimonials = Testimonial::where('active',1)->latest()->paginate(5);
        return TestimonialResource::collection($testimonials);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"testimonials"},
     *      path="/testimonials/{testimonial}",
     *      summary="Get Single testimonial",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="testimonial",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Testimonial $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Testimonial $testimonial)
    {
        if ($testimonial->active)
            return TestimonialResource::make($testimonial);
        return response()->json(['data'=>'Testimonial is Not Active Yet !'],402);
    }
}
