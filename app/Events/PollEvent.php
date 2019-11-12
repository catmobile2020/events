<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PollEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $poll;

    public function __construct($poll)
    {
        $this->poll = $poll;
    }

    public function broadcastOn()
    {
        return \Redis::publish('poll-channel.'.$this->poll['speaker_id'], json_encode([
            'event' => 'poll_event',
            'data'  => $this->poll
        ]));
//        return new Channel('poll-channel.'.$this->poll['speaker_id']);
    }
}
