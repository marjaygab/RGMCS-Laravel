<?php

namespace App\Http\Controllers;

use App\Price;
use Carbon\Carbon;
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

    public static function setPrice($itemno,$price)
    {
        $parameters = [
            'price'=>$price
        ];

        $result = self::getPrice($itemno);


        if ($result == false || $result == null) {
            $result = RGMCSFactory::insertRows(new Price(),env('DB_CONFIG_WAREHOUSE_ENCODER_DB'),['itemno'=>$itemno,'price'=>0.00,'updated_at'=>Carbon::now()]);
            // $result = RGMCSFactory::updateRows(new Price(),env('DB_CONFIG_WAREHOUSE_ENCODER_DB'),['itemno',"=",$itemno],$parameters);
        }else{
            $result = RGMCSFactory::updateRows(new Price(),env('DB_CONFIG_WAREHOUSE_ENCODER_DB'),['itemno'=>$itemno],$parameters);
        }
        return $result > 0;
    }

    
}
