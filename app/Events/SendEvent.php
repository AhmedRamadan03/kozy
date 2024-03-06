<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $student_id;
    public $title;
    public $message;
    public $url;
    public $date;
    public $time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->student_id = $data['user_id'];
        $this->title = $data['title'];
        $this->message = $data['message'];
        $this->url = $data['url'];
        $this->date = date('Y-m-d');
        $this->time = date('H:i:s');
    }


public function broadcastOn()
  {
      return ['send-event'];
  }

  public function broadcastAs()
  {
      return 'new-send-event';
  }
}
