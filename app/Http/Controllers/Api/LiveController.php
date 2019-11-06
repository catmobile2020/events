<?php

namespace App\Http\Controllers\Api;

use App\Events\QuestionEvent;
use App\Http\Resources\QuestionResource;
use App\Speaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveController extends Controller
{

    /**
     *
     * @SWG\Get(
     *      tags={"questions"},
     *      path="/{speaker}/questions",
     *      summary="Get speaker questions",
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
     *         name="speaker",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Speaker $speaker
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function questions(Speaker $speaker)
    {
        $questions = $speaker->questions()->paginate(5);
        return QuestionResource::collection($questions);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"questions"},
     *      path="/live/{speaker}/questions",
     *      summary="Get speaker questions",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="type",
     *         in="header",
     *         required=true,
     *         type="integer",
     *         description="1 => attendee",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="speaker",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="question",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Speaker $speaker
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function sendQuestion(Speaker $speaker,Request $request)
    {
        if (request()->header('type') == 1)
        {
            if ($speaker->enable_questions)
            {
                $user = auth()->user();
                $question = $user->questions()->create(['speaker_id'=>$speaker->id,'question'=>$request->question]);
                $data = [
                  'user_id' => $user->id,
                  'speaker_id' => $speaker->id,
                  'question'=>$request->question,
                ];
                broadcast(new QuestionEvent($data));
                return QuestionResource::make($question);
            }
            return response()->json(['data'=>"Speaker Didn't Enable Questions Yet !"],402);
        }
        return response()->json(['data'=>'You Mast Be Attendee'],402);
    }
}
