<?php

namespace App\Http\Controllers;

use App\Cart;
use App\TransactionType;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $transactionTypeId = $request->post('transaction_type');
        if ($transactionTypeId == 0) {
            return back()->withErrors(['msg'=>'Incomplete / Empty fields submitted.']);
        }else{
            $transactionType = TransactionTypeController::getTransactionType(['id'=>$transactionTypeId],true);
            $itemNo = $request->post('itemno');
            $vid = $request->post('vendor');
            $vendor = VendorController::getVendor(['vid'=>$vid],true)->vendor;
            $unit_cost = $request->post('unit_cost');
            $tDate = $request->post('tdate');
            $qtyIn = 0;
            $qtyOut = 0;
            switch ($transactionType->flow) {
                case 'IN':
                    $qtyIn = $request->post('qty');
                    break;
                case 'OUT':
                    $qtyOut = $request->post('qty');
                    break;
            }

            if (self::insertCartItem($transactionType->description,$itemNo,$vendor,$unit_cost,$qtyIn,$qtyOut,$tDate)) {
                return redirect(route('encode'));
            }else{
                return back()->withErrors(['msg'=>'An error occured while adding to Cart.']);
            }

        }
    }

    public static function getCartItemCount()
    {
        $result = RGMCSFactory::fetchRows(new Cart(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),null);

        return $result->count();
    }

    public static function insertCartItem($transactionType,$itemNo,$vendor,$unit_cost,$qtyIn,$qtyOut,$tDate)
    {
        $parameters = [
            'transaction_type'=>$transactionType,
            'name'=>'Alma',
            'itemno'=>$itemNo,
            'vendor'=>$vendor,
            'unit_cost'=>$unit_cost,
            'qtyin'=>$qtyIn,
            'qtyout'=>$qtyOut,
            'tdate'=>$tDate
        ];
        
        $result = RGMCSFactory::insertRows(new Cart(),env("DB_CONFIG_".env('DEVICE_CODE')."_DB"),$parameters);

        return $result > 0;
    }
}
