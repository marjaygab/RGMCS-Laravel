<?php

namespace App\Http\Controllers;

use App\TransactionsOverview;
use Illuminate\Http\Request;

class TransactionsOverviewController extends Controller
{
    public function getAll(Request $request)
	{
		$transactions = new TransactionsOverview();

        $itemno = $request->route('itemno');

        if ($itemno != null) {
            $result = DataTablesController::generateResult(
                $request,
                $transactions,
                env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),
                [
                    'itemno',
                    'transaction_type',
                    'name', 
                    'itemdesc', 
                    'vendor',
                    'unit_cost', 
                    'qtyin',
                    'qtyout', 
                    'qtyoh', 
                    'tdate',
                    'created_at',
                ],
                'itemdesc',
                ['itemno','=',$itemno]
            );
        }else{
            $result = DataTablesController::generateResult(
                $request,
                $transactions,
                env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),
                [
                    'itemno',
                    'transaction_type',
                    'name', 
                    'itemdesc', 
                    'vendor',
                    'unit_cost', 
                    'qtyin',
                    'qtyout', 
                    'qtyoh', 
                    'tdate',
                    'created_at',
                ],
                'itemdesc'
            );
        }


		

		$data = array();
		foreach ($result['result'] as $key => $transaction) {
			$nestedData = array();
			$nestedData[] = $transaction['itemno'];
            $nestedData[] = $transaction['transaction_type'];
            $nestedData[] = $transaction['name'];
            $nestedData[] = $transaction['itemdesc'];
            $nestedData[] = $transaction['vendor'];
            $nestedData[] = "₱ " . $transaction['unit_cost'];
            $nestedData[] = $transaction['qtyin'];
            $nestedData[] = $transaction['qtyout'];
            $nestedData[] = $transaction['qtyoh'];
            $nestedData[] = $transaction['tdate'];
            $nestedData[] = date_format($transaction['created_at'],"Y/m/d h:i A");

			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
    }
    

}
