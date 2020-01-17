<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //
    public function index(Request $request)
    {
        $toPass = [
            'vendor_options'=>VendorController::generateOptionString(),
            'transaction_type_options'=>TransactionTypeController::generateOptionString()
        ];

        return view('encodetransactions')->with($toPass);
    }

    

    public function encodeItem(Request $request)
    {
        $itemno = $request->route('encodeitemno');
        $item = ItemCatalogController::getItem($itemno);

        $toPass = [
            'vendor_options'=>VendorController::generateOptionString(),
            'transaction_type_options'=>TransactionTypeController::generateOptionString(),
            'encodeitemdesc'=>$item->itemdesc,
            'encodeitemno'=>$itemno,
            'encodeunitcost'=>strval(PriceController::getPrice($itemno)->price)
        ];

        return view('encodetransactions')->with($toPass);
    }
}
