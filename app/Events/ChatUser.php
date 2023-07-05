<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $user_name;
    public $user_image;
    public $message;
    public $time;

    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->user_name = $data['user_name'];
        $this->user_image = $data['user_image'];
        $this->message = $data['message'];
        $this->time = $data['time'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-user');
    }
}
