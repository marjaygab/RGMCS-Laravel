<?php

namespace App\Http\Controllers;

use App\DatabaseHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DatabaseHistoryController extends Controller
{
    //


    public static function generateHistoryString($deviceCode = null)
    {
        $history = self::getHistory($deviceCode);

        if ($history != null) {
            return date_format($history->updated_at,"Y/m/d h:i A") . ' ' . $history->backupCode;
        }else{
            return "";
        }

    }


    public static function getFormattedDate($deviceCode = null)
    {
        $history = self::getHistory($deviceCode);
        return date_format($history->updated_at,"Y/m/d h:i A");
    }

    public static function getBackupCode($deviceCode = null)
    {
        $history = self::getHistory($deviceCode);
        return $history->backupCode;
    }



    public static function getHistory($deviceCode = null)
    {
        if ($deviceCode == null) {
            if (env('DEVICE_CODE') == "RENES_ADMIN") {
                $environment = env('DB_CONFIG_REFERENCES');
            }else{
                $environment = env('DB_CONFIG_' . env('DEVICE_CODE'));
            }
        }else{
            $environment = env('DB_CONFIG_' . $deviceCode);
        }

        $result = RGMCSFactory::fetchRows(new DatabaseHistory(),$environment,['id'=>1],true);
        if ($result != null) {
            return $result;
        }else{
            return false;
        }
    }

    public static function setHistory($environment)
    {
        $parameters = [
            "backupCode"=>self::generateBackupCode(),
            "updated_at"=> Carbon::now('Asia/Manila')
        ];

        $result = RGMCSFactory::updateRows(new DatabaseHistory(),$environment,['id'=>1],$parameters);
        return $result > 0;
    }

    public static function generateBackupCode()
    {
        return RGMCSFactory::random(4);
    }
}
