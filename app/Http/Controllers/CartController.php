<?php

namespace App\Http\Controllers;

use App\Cart;
use App\TransactionType;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        return view('cart');
    }


    public function removeCartItem(Request $request)
    {

        $cartid = $request->route('cartid');
        if (self::deleteCartItem($cartid)) {
            return back();
        }else{
            return back()->withErrors(['msg'=>"An error occured while removing item from cart. Cart ID: " . $cartid]);
        }
    }




    public function addToCart(Request $request)
    {
        $transactionTypeId = $request->post('transaction_type');
        if ($transactionTypeId == 0) {
            return back()->withErrors(['msg'=>'Incomplete / Empty fields submitted.']);
        }else{
            $transactionType = TransactionTypeController::getTransactionType(['id'=>$transactionTypeId],true);
            $itemNo = $request->post('itemno');
            $vid = $request->post('vendor');
            $vendor = VendorController::getVendor($vid,true)->vendor;
            $unit_cost = $request->post('unit_cost');
            $tDate = $request->post('tdate');
            $qtyIn = 0;
            $qtyOut = 0;



            if (TransactionTypeController::flowIs($transactionType->flow,"IN")) {
                # code...
                $qtyIn = $request->post('qty');
            }else if (TransactionTypeController::flowIs($transactionType->flow,"OUT")) {
                $qtyOut = $request->post('qty');
            }

            
            // switch ($transactionType->flow) {
            //     case 'IN':
            //         $qtyIn = $request->post('qty');
            //         break;
            //     case 'OUT':
            //         $qtyOut = $request->post('qty');
            //         break;
            // }

            if (self::insertCartItem($transactionType->description,$itemNo,$vendor,$unit_cost,$qtyIn,$qtyOut,$tDate)) {
                return redirect(route('encode'));
            }else{
                return back()->withErrors(['msg'=>'An error occured while adding to Cart.']);
            }

        }
    }

    public static function getCartItem($cartid = null,$first = null)
    {
        if ($cartid != null) {
            $parameters = ['id'=>$cartid];
        }else{
            $parameters = null;
        }

        $result = RGMCSFactory::fetchRows(new Cart(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),$parameters,$first);

        return $result;
    }

    public static function getCartItemCount()
    {
        $result = self::getCartItem(null,null);

        return $result->count();
    }


    public static function insertCartItem($transactionType,$itemNo,$vendor,$unit_cost,$qtyIn,$qtyOut,$tDate)
    {
        if (session()->has('loggedInUserName')) {
            $name = session()->get('loggedInUserName');
        } else {
            $name = env('DEVICE_CODE');
        }
        
        $parameters = [
            'transaction_type'=>$transactionType,
            'name'=>$name,
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

    public static function deleteCartItem($cartid)
    {

        $parameters = ['id'=>$cartid];
        $result = RGMCSFactory::deleteRows(new Cart(),env("DB_CONFIG_".env('DEVICE_CODE')."_DB"),$parameters);

        return $result > 0;
    }

    public static function clearCart()
    {
        $cart = new Cart();
        return RGMCSFactory::clearTable($cart,env("DB_CONFIG_".env('DEVICE_CODE')."_DB"));
    }
}
