<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //

    const defaultSelection = "RENES_ENCODER";

    public static function getDevices($whereClause = null,$first = null)
    {

        $result = RGMCSFactory::fetchRows(new Device(),env('DB_CONFIG_RENES_ADMIN'),$whereClause,$first);

        if (is_array($result)) {
            if($result->count() > 0){
                return $result;
            }else{
                return false;
            }
        }else{
            if ($result != null) {
                return $result;
            } else {
                return false;
            }
        }

    }


    public static function getDefaultSelection()
    {
        $result = self::getDevices(['deviceCode'=>self::defaultSelection],true);

        return $result;
    }

    public static function generateList()
    {
        $htmlString = "";
        $devices = self::getDevices(null,null);

        if ($devices != false) {
            foreach ($devices as $device) {
                if ($device->deviceCode != "RENES_CASHIER") {
                    $html = "<option value='$device->deviceCode'>" . $device->deviceName . "</option>";
                    $htmlString .= $html;
                }
            }
        }

        return $htmlString;
    }
}
