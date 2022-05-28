<?php

namespace App\Interfaces;

interface PurchaseRepositoryInterface
{
    public function addPurchase (array $data);
    public function checkSubscriptions(int $osID);
    public function fetchExpiredSubscriptions();
}
