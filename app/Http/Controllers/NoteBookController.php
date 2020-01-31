<?php

namespace App\Http\Controllers;

use App\ReceipItemsOverview;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteBookController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('addeditnotebook');
    }

    public function newTransaction(Request $request)
    {
        $receipts = $request->post('receipts');
        $receiptItems = $receipts['items'];
        $tDate = $receipts['tDate'];
        $vid = $receipts['vid'];
        $vendor = $receipts['vendor'];
        $total = $receipts['totalNetPrice'];

        $insertId = ReceiptController::newReceipt($tDate,$vid,$vendor,$total);

        if ($insertId != null) {
            $newItems = array();

            foreach ($receiptItems as $item) {
                $temp = array();
                $temp['receipt_id'] = $insertId;
                $temp['itemno'] = $item['itemno'];
                $temp['itemdesc'] = $item['itemdesc'];
                $temp['baseprice'] = $item['base'];
                $temp['d1'] = $item['d1'];
                $temp['d2'] = $item['d2'];
                $temp['d3'] = $item['d3'];
                $temp['d4'] = $item['d4'];
                $temp['netprice'] = $item['netprice'];
                $temp['created_at'] = Carbon::now();
                $temp['updated_at'] = Carbon::now();

                $newItems[] = $temp;
            }

            $result = ReceiptItemsController::newReceiptItem($newItems);
            if ($result =! false) {
                $response['success'] = true;
            }else{
                $response['success'] = false;
            }
        }else{
            $response['success'] = false;
        }

        return $response;
    }
}
