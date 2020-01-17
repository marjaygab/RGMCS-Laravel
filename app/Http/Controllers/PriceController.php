<?php

namespace App\Http\Controllers;

use App\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    //

    public static function getPrice($itemno)
    {
        $priceList = new Price();
        $result = RGMCSFactory::fetchRows($priceList,env('DB_CONFIG_WAREHOUSE_ENCODER'),['itemno'=>$itemno],true);

        return $result;
    }

    
}
