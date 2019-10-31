<?php

namespace App\Http\Controllers\Api;

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
     *      path="/partnerships",
     *      summary="Get partnerships",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        $partnerships = Partnership::where('active',1)->latest()->paginate(5);
        return PartnershipResource::collection($partnerships);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"partnerships"},
     *      path="/partnerships/{partnership}",
     *      summary="Get Single partnership",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="partnership",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Partnership $partnership
     * @return PartnershipResource|\Illuminate\Http\JsonResponse
     */
    public function show(Partnership $partnership)
    {
        if ($partnership->active)
            return PartnershipResource::make($partnership);
        return response()->json(['data'=>'Partnership is Not Active Yet !'],402);
    }
}
