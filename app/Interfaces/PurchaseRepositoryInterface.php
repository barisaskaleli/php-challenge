<?php

namespace App\Interfaces;

interface PurchaseRepositoryInterface
{
    public function addPurchase (array $data);
    public function editPurchase (string $expiredDate, int $id);
    public function checkSubscriptions(int $osID);
    public function fetchExpiredSubscriptions();
}
