<?php

namespace App\Jobs;

use App\Http\Controllers\MobileVerify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateExpiredSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    protected $subscription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($expiredSubscriptions)
    {
        $this->subscription = $expiredSubscriptions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $check = app(MobileVerify::class)->redirectToSelectedOsViaJob($this->subscription->id, $this->subscription->receipt_hash, $this->subscription->device->operating_system);

        // if check returns false retry the job
        if (!$check) {
            $this->fail($check);
        }
    }
}
