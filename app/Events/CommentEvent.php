<?php

namespace App\Events;

use App\Event;
use App\Notifications\EventNotification;
use App\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Notification;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;

        $event = Event::find($comment['event_id']);
        $users = $event->users;
        $users[]=$event->user;
        $users=$users->merge($event->speakers);
        $notify['info'] = $comment['user']['name'].' add New Comment To '.str_limit(Post::find($comment['post_id'])->desc,15);
        $notify['url'] = route('admin.posts.comments.index',$comment['post_id']);
        foreach ($users as $user)
        {
            $notify['user_id'] = $user->id;
            Notification::send($user,new EventNotification($notify));
        }
    }

    public function broadcastOn()
    {
        return \Redis::publish('comment-channel.'.$this->comment['post_id'], json_encode([
            'event' => 'comment_event',
            'data'  => $this->comment
        ]));
//        return new Channel('comment-channel.'.$this->comment['event_id']);
    }
}
