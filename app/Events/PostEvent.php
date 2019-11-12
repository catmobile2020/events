<?php

namespace App\Events;

use App\Event;
use App\Notifications\EventNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Notification;

class PostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct($post)
    {
        $this->post = $post;

        $event = Event::find($post['event_id']);
        $users = $event->users;
        $users[]=$event->user;
        $users=$users->merge($event->speakers);
        $notify['info'] = $post['user']['name'].' add New Post To '.$event->name;
        $notify['url'] = route('admin.posts.index',$post['event_id']);
        foreach ($users as $user)
        {
            $notify['user_id'] = $user->id;
            Notification::send($user,new EventNotification($notify));
        }

    }

    public function broadcastOn()
    {
        return \Redis::publish('post-channel.'.$this->post['event_id'], json_encode([
            'event' => 'post_event',
            'data'  => $this->post
        ]));
//        return new Channel('post-channel.'.$this->post['event_id']);
    }
}
