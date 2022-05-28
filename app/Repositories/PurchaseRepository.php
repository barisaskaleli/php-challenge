<?php

namespace App\Repositories;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Purchase;

class PurchaseRepository implements PurchaseRepositoryInterface
{

    public function addPurchase(array $data)
    {
        return Purchase::create($data);
    }

    public function checkSubscriptions(int $osID)
    {
        return Purchase::where('device_id', $osID)->get();
    }

    public function fetchExpiredSubscriptions()
    {
        return Purchase::where('expiration_date', '<', date('Y-m-d'))->get();
    }
}
