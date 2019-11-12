<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventNotification extends Notification
{
    use Queueable;

    public $notify;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notify)
    {
        $this->notify = $notify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $this->notify['id'] = $this->id;
        $this->notify['created_at'] = now()->diffForHumans();
        return [
            'notify'=>$this->notify
        ];
    }

    public function broadcastOn()
    {
        return \Redis::publish('notify-channel.'.$this->notify['user_id'], json_encode([
            'event' => 'notify_event',
            'data'  => $this->notify
        ]));
    }
}
