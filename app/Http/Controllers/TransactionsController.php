<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Transaction;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;

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

    public function adminViewTransactions(Request $request)
    {
        $selection = $request->route('selection');
        $defaultSelection = DeviceController::getDefaultSelection();

        if ($selection != null) {
            $selectionObject = DeviceController::getDevices(['deviceCode'=>$selection],true);
            if ($selectionObject != false) {
                return view('admintransactions')->with('selection',$selectionObject);
            }else{
                return view('admintransactions')->with('selection',$defaultSelection)->withErrors(['msg'=>"Device does not exist."]);
            }
        }else{
            return view('admintransactions')->with('selection',$defaultSelection);
        }
    }

    public function viewTransactions(Request $request)
    {
        return view('viewtransactions');
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

    public function processCart()
    {
        $cartItems = CartOverviewController::getCartOverviewItem(null,null);

        $flow = '';
        $errors = array();
        foreach ($cartItems as $item) {
            $transaction_type = $item['transaction_type'];
            $itemdesc = $item['itemdesc'];
            $itemno = $item['itemno'];
            $flow = TransactionTypeController::getFlow($transaction_type);

            if ($flow == 'IN' || $flow == 'OUT') {
                $result = $this->setQty($itemno,$flow,$item['qtyin'],$item['qtyout']);

                if ($result == false) {
                    $errors[] = "An error occured while processing '" . $itemdesc . "'";
                }else{
                    $result = $this->newTransaction($item);
                    if ($result == false) {
                        $errors[] = "An error occured while processing '" . $itemdesc . "'";
                    }
                }
                
            }else if ($flow =='NA') {
                if (env('DEVICE_CODE') == "WAREHOUSE_ENCODER") {
                    $this->setPrice($itemno,$item['price']);
                }
            }
        }

        if (count($errors) <= 0) {
            RGMCSFactory::truncateRows(new Cart(),env("DB_CONFIG_".env('DEVICE_CODE')."_DB"));
            return back();
        }else{
            $error = implode("<br>",$errors);
            return back()->withErrors(['msg'=>$error]);
        }
    }

    public function newTransaction($cartItem)
    {
        $parameters = [
            'transaction_type'=>$cartItem['transaction_type'],
            'name'=>$cartItem['name'],
            'itemno'=>$cartItem['itemno'],
            'vendor'=>$cartItem['vendor'],
            'unit_cost'=>$cartItem['unit_cost'],
            'qtyin'=>$cartItem['qtyin'],
            'qtyout'=>$cartItem['qtyout'],
            'tdate'=>$cartItem['tdate'],
            'created_at'=>$cartItem['created_at'],
        ]; 

        $result = StockController::getStock($cartItem['itemno'],true);
        if ($result != false) {
            $parameters['qtyoh'] = $result['qty'];
            
            $result = RGMCSFactory::insertRows(new Transaction(),env("DB_CONFIG_".env('DEVICE_CODE')."_DB"),$parameters);
            
            return $result > 0;
        }else{
            return false;
        }

    }



    public function setQty($itemno,$flow,$qtyin,$qtyout)
    {
        $result = StockController::setQty($itemno,$qtyin,$qtyout);
        return $result;
    }

    public function setPrice($itemno,$price)
    {
        # code...
    }

    
    



}
