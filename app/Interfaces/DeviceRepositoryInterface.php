<?php

namespace App\Interfaces;

interface DeviceRepositoryInterface
{
    public function addDevice (array $data);
    public function checkIsDeviceExists(int $uid, string $os);
}
