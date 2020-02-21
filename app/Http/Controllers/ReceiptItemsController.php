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

    public function updateReceiptItem(Request $request)
    {
        $parameters = [
            'itemno'=>$request->post('itemno'),
            'itemdesc'=>ItemCatalogController::getItem($request->post('itemno'))->itemdesc,
            'baseprice'=>$request->post('basePrice'),
            'd1'=>$request->post('d1'),
            'd2'=>$request->post('d2'),
            'd3'=>$request->post('d3'),
            'd4'=>$request->post('d4'),
            'netprice'=>$request->post('netPrice')
        ];

        $result = self::updateItem($request->post('receipt_item_no'),$parameters);
        

        if ($result) {
            $result = ReceiptController::recalculateTotal($request->post('receipt_id'));
            if ($result) {
                # code...
                return back();
            }else{
                return back()->withErrors(['msg'=>"An error occured in updating receipt item total."]);
            }            
        }else{
            return back()->withErrors(['msg'=>"An error occured in updating receipt item."]);
        }
    }

    public function getReceiptItem(Request $request)
    {
        $inputParams = $request->get('receipt_item_no');

        $result = self::getItems($inputParams);

        return json_encode($result);
    }

    public static function updateItem($receipt_item_no,$parameters)
    {
        $result = RGMCSFactory::updateRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'),['id'=>$receipt_item_no],$parameters);

        return $result > 0;
    }

    public static function getItems($receipt_item_no = null,$whereClause = null)
    {
        if ($receipt_item_no != null) {
            $result = RGMCSFactory::fetchRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'),['id'=>$receipt_item_no],true);
            if ($result != null) {
                return $result;
            }else{
                return false;
            }
        }else{
            if ($whereClause == null) {
                $result = RGMCSFactory::fetchRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'));
                return $result;
            }else{
                $result = RGMCSFactory::fetchRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'),$whereClause);
                return $result;
            }
            
        }
    }

    public static function getTotal($receipt_no)
    {
        $total = 0;

        $receiptItems = self::getItems(null,['receipt_id'=>$receipt_no]);

        foreach ($receiptItems as $value) {
            $total += $value->netprice;
        }

        return $total;
    }
}
