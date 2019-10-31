<?php

namespace App\Http\Controllers\Api;

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
     *      path="/sponsors",
     *      summary="Get sponsors",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        $sponsors = Sponsor::where('active',1)->latest()->paginate(5);
        return SponsorResource::collection($sponsors);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"sponsors"},
     *      path="/sponsors/{sponsor}",
     *      summary="Get Single sponsor",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="sponsor",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Sponsor $sponsor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Sponsor $sponsor)
    {
        if ($sponsor->active)
            return SponsorResource::make($sponsor);
        return response()->json(['data'=>'Sponsor is Not Active Yet !'],402);
    }
}
