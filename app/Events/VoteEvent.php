<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VoteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vote;

    public function __construct($vote)
    {
        $this->vote = $vote;
    }

    public function broadcastOn()
    {
        return \Redis::publish('vote-channel.'.$this->vote['poll_id'], json_encode([
            'event' => 'vote_event',
            'data'  => $this->vote
        ]));
//        return new Channel('vote-channel.'.$this->vote['poll_id']);
    }
}
