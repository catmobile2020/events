<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\BannerResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"banners ads"},
     *      path="/banners",
     *      summary="Get banners",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        $banners = Banner::where('active',1)->latest()->paginate(5);
        return BannerResource::collection($banners);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"banners ads"},
     *      path="/banners/{banner}",
     *      summary="Get Single banner",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="banner",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Banner $banner
     * @return BannerResource|\Illuminate\Http\JsonResponse
     */
    public function show(Banner $banner)
    {
        if ($banner->active)
            return BannerResource::make($banner);
        return response()->json(['data'=>'Banner is Not Active Yet !'],402);
    }
}
