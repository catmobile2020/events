<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuestionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question;


    public function __construct($question)
    {
        $this->question = $question;
    }

    public function broadcastOn()
    {
        return \Redis::publish('question-channel.'.$this->question['speaker_id'], json_encode([
            'event' => 'question_event',
            'data'  => $this->question
        ]));
//        return new Channel('question-channel.'.$this->question['speaker_id']);
    }
}
