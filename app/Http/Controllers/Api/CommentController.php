<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Events\CommentEvent;
use App\Http\Requests\Api\CommentRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\SpeakersResource;
use App\Post;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     *
     * @SWG\Post(
     *      tags={"comments"},
     *      path="/events/{post}/comments",
     *      summary="Add new Comment To Post",
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
     *         name="post",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="desc",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Post $post
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Post $post,CommentRequest $request)
    {
        if ($post->event->active)
        {
            $user= auth()->user();
            $inputs = $request->all();
            $user_type = $request->header('type');
            $inputs['user_type'] = $user_type;
            if ($user_type == 2)
            {
                $inputs['speaker_id'] = $user->id;
                $inputs['user_type'] = 'speaker';
            }else
            {
                $inputs['user_id'] = $user->id;
                $inputs['user_type'] = 'attendee';
            }
            $comment = $post->comments()->create($inputs);

            $data = [
                'post_id' =>$comment->post_id,
                'desc'=>$comment->desc,
                'type'=>$comment->user_type,
            ];
            if ($post->speaker)
            {
                $data['user'] = SpeakersResource::make($post->speaker);
            }else
            {
                $data['user'] = AccountResource::make($post->user);
            }
            broadcast(new CommentEvent($data));
            return  CommentResource::make($comment);
        }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Put(
     *      tags={"comments"},
     *      path="/events/{post}/comments/{comment}",
     *      summary="update Comment",
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
     *         name="post",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="desc",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *     @SWG\Parameter(
     *         name="_method:put",
     *         in="formData",
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Post $post
     * @param Comment $comment
     * @param CommentRequest $request
     * @return CommentResource
     */
    public function update(Post $post,Comment $comment,CommentRequest $request)
    {
        $comment->update(['desc'=>$request->desc]);
        return  CommentResource::make($comment);
    }
}
