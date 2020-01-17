<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceConfiguration extends Controller
{
    //
    public function readJson()
    {
        $path = storage_path() . "/config/device_configuration.json";
        $json = json_decode(file_get_contents($path),true);
        return $json;
    }
    
    public static function getDeviceCode()
    {
        return env("DEVICE_CODE");
    }

    public static function getDBName(){
        $deviceConfig = new DeviceConfiguration;
        $deviceCode = $deviceConfig->getDeviceCode();
        return "mysql_" . strtolower($deviceCode);
    }

}
