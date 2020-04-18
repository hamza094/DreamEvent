<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReplyAddedToDiscussion extends Notification
{
    use Queueable;

    protected $reply;
    protected $replydiscussion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reply, $replydiscussion)
    {
        $this->reply = $reply;
        $this->replydiscussion = $replydiscussion;
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
            'message'=>' New discussion added by '.$this->replydiscussion->user->name,
            'notifier'=>$this->replydiscussion->user,
            'link'=>$this->reply->path()
        ];
    }
}
