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

    public function editPurchase($expiredDate, $id)
    {
        $subs = Purchase::find($id);
        $subs->expired_at = $expiredDate;
        return $subs->save();
    }

    public function checkSubscriptions(int $osID)
    {
        return Purchase::where('device_id', $osID)->get();
    }

    public function fetchExpiredSubscriptions()
    {
        return Purchase::with('device')->where('expired_at', '<', date('Y-m-d H:i'))->get();
    }
}
