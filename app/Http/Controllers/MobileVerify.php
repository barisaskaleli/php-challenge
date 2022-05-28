<?php

namespace App\Http\Controllers;

use App\Interfaces\DeviceRepositoryInterface;
use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Purchase;
use App\Http\Traits\RespondsWithHttpStatus;
use Illuminate\Http\JsonResponse;

class MobileVerify extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * @var DeviceRepositoryInterface
     */
    private DeviceRepositoryInterface $deviceRepository;

    /**
     * @var PurchaseRepositoryInterface
     */
    private PurchaseRepositoryInterface $purchaseRepository;

    /**
     * @param DeviceRepositoryInterface $deviceRepository
     * @param PurchaseRepositoryInterface $purchaseRepository
     */
    public function __construct(DeviceRepositoryInterface $deviceRepository, PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->purchaseRepository = $purchaseRepository;
    }


    /**
     * @param $receipt
     * @param $operatingSystem
     * @param $operatingSystemID
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function redirectToSelectedOs($receipt, $operatingSystem, $operatingSystemID){
        if($operatingSystem == 'android'){
            return $this->iosVerify($receipt, $operatingSystemID);
        }
        elseif($operatingSystem == 'ios'){
            return $this->iosVerify($receipt, $operatingSystemID);
        }
    }

    /**
     * @param $receipt
     * @param $operatingSystemID
     * @return \Illuminate\Http\JsonResponse
     */
    private function iosVerify($receipt, $operatingSystemID): JsonResponse
    {
        $lastCharacter = substr($receipt, -1);
        if(is_numeric($lastCharacter)){
            if($lastCharacter % 2 == 1){
                $expireDate = date('Y-m-d H:i:s', strtotime(   '+'.rand(1, 30).' days'));

                $this->purchaseRepository->addPurchase([
                    'device_id' => $operatingSystemID,
                    'expired_at' => $expireDate,
                    'receipt_hash' => $receipt
                ]);

                return $this->success('OK', ['status' => true, 'expire_date' => $expireDate]);
            }
        }

        return $this->failure("Services can't verify receipt.");
    }

    /**
     * @param $receipt
     * @param $operatingSystemID
     * @return \Illuminate\Http\JsonResponse
     */
    private function androidVerify($receipt, $operatingSystemID): JsonResponse
    {
        $receipt = substr($receipt, -1);
        if(is_numeric($receipt)){
            if($receipt % 2 == 1){
                $expireDate = date('Y-m-d H:i:s', strtotime(   '+'.rand(1, 30).' days'));

                $this->purchaseRepository->addPurchase([
                    'device_id' => $operatingSystemID,
                    'expired_at' => $expireDate,
                    'receipt_hash' => $receipt
                ]);

                return $this->success('OK', ['status' => true, 'expire_date' => $expireDate]);
            }
        }

        return $this->failure("Services can't verify receipt.");
    }
}
