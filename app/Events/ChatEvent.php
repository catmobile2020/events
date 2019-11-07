<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct($chat)
    {
        $this->chat = $chat;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return \Redis::publish('chat-channel.'.$this->chat['event_id'], json_encode([
            'event' => 'chat_event',
            'data'  => $this->chat
        ]));
//        return new Channel('chat-channel.'.$this->chat['event_id']);
    }
}
