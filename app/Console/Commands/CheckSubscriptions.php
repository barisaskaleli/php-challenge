<?php

namespace App\Console\Commands;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Jobs\CheckSubscriptionIsExpiredJob;
use Illuminate\Console\Command;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var PurchaseRepositoryInterface
     */
    private PurchaseRepositoryInterface $purchaseRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        parent::__construct();
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredSubscriptions = $this->purchaseRepository->fetchExpiredSubscriptions();
        if ($expiredSubscriptions != null) {
            CheckSubscriptionIsExpiredJob::dispatch($expiredSubscriptions);
        }
    }
}
