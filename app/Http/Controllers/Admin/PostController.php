<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Event;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\PostRequest;
use App\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    use UploadImage;

    public function __construct()
    {
        $this->middleware('permission:posts');
    }

    public function index(Event $event)
    {
        $rows = $event->posts()->latest()->paginate(20);
        return view('admin.pages.post.index',compact('rows','event'));
    }


    public function create(Event $event)
    {
        $post = new Post;
        return view('admin.pages.post.form',compact('post','event'));
    }


    public function store(Event $event,PostRequest $request)
    {
        $user= auth()->user();
        $inputs = $request->all();
        $inputs['event_id'] = $event->id;
        $post = $user->posts()->create($inputs);
        $this->upload($request->photo,$post);
        return redirect()->route('admin.posts.index',$event->id)->with('message','Done Successfully');
    }

    public function edit(Event $event,Post $post)
    {
        return view('admin.pages.post.form',compact('post','event'));
    }


    public function update(Event $event,PostRequest $request, Post $post)
    {
        $post->update(['desc'=>$request->desc]);
        if ($request->photo)
            $this->upload($request->photo,$post,null,true);

        return redirect()->route('admin.posts.index',$event->id)->with('message','Done Successfully');
    }


    public function destroy(Event $event,Post $post)
    {
        $post->trash();
        return redirect()->route('admin.posts.index',$event->id)->with('message','Done Successfully');
    }

    public function comments(Post $post)
    {
        $rows = $post->comments()->paginate(20);
        return view('admin.pages.post.comments',compact('rows','post'));
    }

    public function deleteComment(Post $post,Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.posts.comments.index',$post->id)->with('message','Done Successfully');
    }
}
