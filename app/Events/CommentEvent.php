<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
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
