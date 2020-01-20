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

    public static function getStock($itemno = null,$first = null)
    {
        
        if ($itemno == null) {
            $parameters = null;
        }else{
            $parameters = ['itemno'=>$itemno];
        }

        $result = RGMCSFactory::fetchRows(new Stock(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),$parameters,$first);

        if ($result != null) {
            return $result;
        }else{
            return false;
        }

    }

    public static function setStock($itemno,$parameters)
    {
        
        $result = RGMCSFactory::updateRows(new Stock(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),['itemno'=>$itemno],$parameters);
        return $result > 0;
    }


}
