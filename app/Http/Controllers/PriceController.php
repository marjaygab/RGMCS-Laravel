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

    public function setPrice($itemno,$price)
    {
        $parameters = [
            'price'=>$price
        ];

        $result = RGMCSFactory::updateRows(new Price(),env('DB_CONFIG_WAREHOUSE_ENCODER_DB'),['itemno',"=",$itemno],$parameters);

        return $result > 0;
    }

    
}
