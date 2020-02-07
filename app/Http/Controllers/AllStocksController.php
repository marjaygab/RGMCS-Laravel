<?php

namespace App\Http\Controllers;

use App\AllStocks;
use Illuminate\Http\Request;

class AllStocksController extends Controller
{
    //

    public function admingetAll(Request $request)
	{
		$itemListView = new AllStocks();


		$result = DataTablesController::generateResult(
			$request,   
			$itemListView,
			env("DB_CONFIG_" . "REFERENCES"),
			['id', 'itemdesc', 'unit_code','qty2','qtyr','qtyw','price', 'action'],
            'itemdesc'
		);

		$data = array();
		$additionalInfo = array();
		foreach ($result['result'] as $key => $vendor) {
			$nestedData = array();
            $itemno = $vendor['id'];
			$nestedData[] = $itemno;	
			$nestedData[] = $vendor['itemdesc'];
            $nestedData[] = $vendor['unit_code'];
            $nestedData[] = $vendor['qty2'];
            $nestedData[] = $vendor['qtyr'];
            $nestedData[] = $vendor['qtyw'];

			// $renesQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_RENES_ENCODER')));
			// $redorQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_REDOR_ENCODER')));
			// $warehouseQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_WAREHOUSE_ENCODER')));

			// $nestedData[] = $renesQty;
			// $nestedData[] = $redorQty;
			// $nestedData[] = $warehouseQty;

			$price = PriceController::getPrice($itemno);

			if ($price == false || $price == null) {
				$price = "N/A";		
			}else{
				$price = "₱ " . PriceController::getPrice($itemno)->price;
			}

            $nestedData[] = $price;
            
            $viewroute = route('adminviewitemtransactions', ['itemno' => $itemno]);

            $viewAction = "<a href='$viewroute' class='btn btn-info btn-icon-split btn-sm ml-4'>
            <span class='icon text-white-50'>
              <i class='fas fa-eye'></i>
            </span>
            <span class='text'>View Transaction</span>
          </a>";

			$nestedData[] =  $viewAction;

			
			// $conditionRenes = $this->hasStock($renesQty);
			// $conditionRedor = $this->hasStock($redorQty);
			// $conditionWarehouse = $this->hasStock($warehouseQty);



			// $info = array();
			// $info['itemno'] = $itemno;
			// $info['conditionRenes'] = $conditionRenes;
			// $info['conditionRedor'] = $conditionRedor;
			// $info['conditionWarehouse'] = $conditionWarehouse;

			// $additionalInfo[] = $info;

			// if ($conditionRenes || $conditionRedor || $conditionWarehouse) {
			// 	$data[] = $nestedData;
			// }

			$data[] = $nestedData;

		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data,$additionalInfo);
	}

}
