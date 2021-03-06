<?php

namespace App\Jobs;

use App\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckSubscriptionIsExpiredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $expiredSubscriptions;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($expiredSubscriptions)
    {
        $this->expiredSubscriptions = $expiredSubscriptions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->expiredSubscriptions as $expiredSubscription) {
            UpdateExpiredSubscriptionsJob::dispatch($expiredSubscription);
        }
    }
}
