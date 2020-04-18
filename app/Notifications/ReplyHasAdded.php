<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReplyHasAdded extends Notification
{
    use Queueable;

    protected $event;
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event, $reply)
    {
        $this->event = $event;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message'=>' New replied added to '.$this->event->name.' by '.$this->reply->user->name,
            'notifier'=>$this->reply->user,
            'link'=>$this->reply->path()
        ];
    }
}
