<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\ReceiptItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    //

   

    public static function newReceipt($tDate,$vid,$vendor,$total)
    {
        $parameters=  [
            "tdate"=>$tDate,
            "vid"=>$vid,
            "vendor"=>$vendor,
            "total"=>$total,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];

        $result = RGMCSFactory::insertRowsId(new Receipt(),env('DB_CONFIG_RENES_ADMIN'),$parameters);

        return $result;
    }

}
