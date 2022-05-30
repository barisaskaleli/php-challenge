<?php

namespace App\Listeners;

use App\Events\StartedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class CanceledListener implements ShouldQueue
{
    /**
     * @var string
     */
    public string $connection = 'redis';

    /**
     * @var string
     */
    public string $queue = 'default';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\StartedEvent  $event
     * @return void
     */
    public function handle(StartedEvent $event)
    {
        Http::post('http://localhost:8080/api/v1/canceled', [
            'deviceID' => $event->deviceID,
            'appID' => $event->appID,
            'event' => $event->event,
        ]);
    }
}
