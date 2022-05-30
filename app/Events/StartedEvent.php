<?php

namespace App\Events;

use http\Env\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $deviceID;
    public $appID;
    public $event = 'started';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($deviceID, $appID)
    {
        $this->deviceID = $deviceID;
        $this->appID = $appID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
