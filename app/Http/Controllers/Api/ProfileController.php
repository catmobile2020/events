<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UploadImage;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\AccountResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use UploadImage;

    /**
     *
     * @SWG\Get(
     *      tags={"account"},
     *      path="/account/me",
     *      summary="Get the current logged in user",
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
    public function me()
    {
        if (\request()->header('type') == 2)
        {
            return SpeakerResource::make(auth()->user());
        }
        return AccountResource::make(auth()->user());
    }


    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update",
     *      summary="update My Account",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee , 2=> speaker",
     *         format="integer",
     *      ),
     *      @SWG\Parameter(
     *         name="name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoud",
     *      ),@SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="01205528825",
     *      ),@SWG\Parameter(
     *         name="enable_questions",
     *         in="formData",
     *         required=true,
     *         type="integer",
     *         default="0",
     *      ),@SWG\Parameter(
     *         name="bio",
     *         in="formData",
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="m.mohamed@cat.com.eg",
     *      ),@SWG\Parameter(
     *         name="photo",
     *         in="formData",
     *         type="file",
     *      ),
     *
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param RegisterRequest $request
     * @return AccountResource
     */
    public function update(RegisterRequest $request)
    {
        $user = auth()->user();
        $user->update($request->all());
        if ($request->photo)
            $this->upload($request->photo,$user,null,true);

        auth()->invalidate();
        $token= auth()->tokenById($user->id);
        return $this->respondWithToken($token,$user->type);
//        if (\request()->header('type') == 2)
//        {
//            return SpeakerResource::make($user);
//        }
//        return AccountResource::make($user);
    }


    /**
     *
     * @SWG\post(
     *      tags={"account"},
     *      path="/account/update-password",
     *      summary="update My Password",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee , 2=> speaker",
     *         format="integer",
     *      ),
     *      @SWG\Parameter(
     *         name="current_password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),@SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="User Model"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return AccountResource|\Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        if (Hash::check($request->current_password,$user->password))
        {
            if ($request->current_password === $request->password)
            {
                return response()->json(['data'=>"same password"],200);
            }
            $user->update(['password'=>$request->password]);

            return AccountResource::make($user);
        }
        return response()->json(['data'=>"wrong password"],400);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"ticketing"},
     *      path="/account/my-tickets",
     *      summary="Get my tickets",
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
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function myTickets()
    {
        if (request()->hasHeader('type') and request()->header('type') == 2)
        {
            return response()->json(['data'=>"User Type Wrong Try Again"],400);
        }
        $user = auth()->user();
        $tickets = $user->tickets;
        return TicketResource::collection($tickets);
    }

    protected function respondWithToken($token,$type)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'auth_type' => $type,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
