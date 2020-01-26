<?php

namespace Tests\Unit;

use App\Device;
use App\Http\Controllers\DeviceController;
use PHPUnit\Framework\TestCase;

class DeviceControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $deviceController = new DeviceController();

        $result = $deviceController->getDevices();

        $hasContents = false;

        if ($result->count() > 0) {
            $hasContents = true;
        }

        $this->assertTrue($hasContents);
        
    }
}
