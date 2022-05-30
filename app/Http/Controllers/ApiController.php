<?php

namespace App\Http\Controllers;

use App\Events\CanceledEvent;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\DeviceRepositoryInterface;
use App\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class ApiController extends Controller
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
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        // if client and device doesn't exist, create it
        $device = $this->deviceRepository->checkIsDeviceExists($data['uid'], $data['operating_system']);

        if (!$device)
            $device = $this->deviceRepository->addDevice($data);

        // if everything is ok, create new token
        $token = $device->createToken($data['operating_system'])->plainTextToken;
        return $this->success('Successful.', ['client_token' => $token]);
    }

    /**
     * @param PurchaseRequest $request
     * @return JsonResponse
     */
    public function purchase(PurchaseRequest $request): JsonResponse
    {
        $data = $request->validated();

        $receipt = $data['receipt_hash'];

        return app(MobileVerify::class)->redirectToSelectedOs($receipt, $request->user()->operating_system, $request->user()->id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkSubscriptions(Request $request): JsonResponse
    {
        $purchases = $this->purchaseRepository->checkSubscriptions($request->user()->id);

        if ($purchases->isEmpty()) {
            event(new CanceledEvent($request->user()->operating_system, $request->user()->appId));
        }

        $purchases->transform(function ($purchase) {
            $purchase->expired_at = $purchase->expired_at->format('d-m-Y H:i:s');
            return $purchase;
        });

        return $this->success('Successful.', ['subscriptions' => $purchases]);
    }
}
