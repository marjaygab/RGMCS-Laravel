<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('stocks');
    }

    public function adminIndex(Request $request)
    {
        return view('adminstocks');
    }

    public static function setQty($itemno,$qtyin,$qtyout)
    {
        $stock = self::getStock($itemno,true);
        
        if ($stock != false) {
            $qty = $stock->qty;
            $new_qty = ($qty+$qtyin) - $qtyout;

            $parameters = ['qty'=>$new_qty];
            $result = self::setStock($itemno,$parameters);

            return $result > 0;
        }else{
            return false;
        }
    }

    public static function getStock($itemno = null,$first = null,$environment = null)
    {
        
        if ($itemno == null) {
            $parameters = null;
        }else{
            $parameters = ['itemno'=>$itemno];
        }

        if ($environment == null) {
            $environment = env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB");
        }

        $result = RGMCSFactory::fetchRows(new Stock(),$environment,$parameters,$first);

        if ($result != null) {
            return $result;
        }else{
            return false;
        }

    }


    public static function newStock($itemno ,$environment)
    {
        $result = RGMCSFactory::insertRows(new Stock(),$environment,['itemno'=>$itemno,'qty'=>0]);

        return $result;
    }

    public static function setStock($itemno,$parameters)
    {
        
        $result = RGMCSFactory::updateRows(new Stock(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),['itemno'=>$itemno],$parameters);
        return $result > 0;
    }


}
