<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Events\PostEvent;
use App\Helpers\UploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Http\Resources\SpeakersResource;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use UploadImage;
    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/{event}/posts",
     *      summary="Get event posts",
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
     *         name="event",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Event $event)
    {
        if ($event->active)
            return PostsResource::collection($event->posts()->paginate(5));
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"events"},
     *      path="/events/{event}/posts/{post}",
     *      summary="Get single post",
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
     *         name="event",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Event $event,Post $post)
    {
        if ($event->active)
            return PostResource::make($post);
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"events"},
     *      path="/events/{event}/posts",
     *      summary="Add new Post To Event",
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
     *         name="event",
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
     *         name="photo",
     *         in="formData",
     *         type="file",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(Event $event,PostRequest $request)
    {
        if ($event->active)
            {
                $user= auth()->user();
                $inputs = $request->all();
                $inputs['event_id'] = $event->id;
                $post = $user->posts()->create($inputs);
                if ($request->photo)
                    $this->upload($request->photo,$post);

                $data = [
                    'event_id' =>$post->event_id,
                    'desc'=>$post->desc,
                    'photo' =>$post->photo,
                ];
                if ($post->speaker)
                {
                    $data['type'] = 'speaker';
                    $data['user'] = SpeakersResource::make($post->speaker);
                }else
                {
                    $data['type'] = 'attendee';
                    $data['user'] = AccountResource::make($post->user);
                }
                broadcast(new PostEvent($data));

                return  PostResource::make($post);
            }
        return response()->json(['data'=>'Event is Not Active Yet !'],402);
    }

    /**
     *
     * @SWG\post(
     *      tags={"events"},
     *      path="/events/{event}/posts/{post}/update",
     *      summary="update Event Post",
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
     *         name="event",
     *         in="path",
     *         required=true,
     *         type="integer",
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
     *     @SWG\Parameter(
     *         name="photo",
     *         in="formData",
     *         type="file",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Event $event
     * @param PostRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(Event $event,PostRequest $request,Post $post)
    {
        $post->update(['desc'=>$request->desc]);
        if ($request->photo)
            $this->upload($request->photo,$post,null,true);
        return  PostResource::make($post);
    }
}
