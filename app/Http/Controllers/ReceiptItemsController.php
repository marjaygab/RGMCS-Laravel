<?php

namespace App\Http\Controllers;

use App\ReceiptItems;
use Illuminate\Http\Request;

class ReceiptItemsController extends Controller
{
    //

    public static function newReceiptItem($receiptItems)
    {
        $result = RGMCSFactory::insertRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'),$receiptItems);
        if ($result > 0) {
            return true;
        }else{
            return false;
        }
    }
}
