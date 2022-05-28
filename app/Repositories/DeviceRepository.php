<?php

namespace App\Repositories;

use App\Interfaces\DeviceRepositoryInterface;
use App\Models\Devices;

class DeviceRepository implements DeviceRepositoryInterface
{

    public function addDevice(array $data)
    {
        return Devices::create($data);
    }

    public function checkIsDeviceExists(int $uid, string $os)
    {
        return Devices::where('uid', $uid)->where('operating_system', $os)->first();
    }
}
