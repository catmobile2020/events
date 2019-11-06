<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct($post)
    {
        $this->post = $post;
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
