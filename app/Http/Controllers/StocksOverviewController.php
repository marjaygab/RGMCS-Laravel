<?php

namespace App\Http\Controllers;

use App\ItemList;
use App\StocksOverview;
use Illuminate\Http\Request;

class StocksOverviewController extends Controller
{
    //

    public function getAll(Request $request)
	{
		$stocksOverview = new StocksOverview();

		$result = DataTablesController::generateResult(
			$request,
			$stocksOverview,
			env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),
			['itemno', 'itemdesc', 'unit_code','qty','price', 'action'],
			'itemdesc'
		);

		$data = array();
		foreach ($result['result'] as $key => $vendor) {
			$nestedData = array();
			$itemno = $vendor['itemno'];
			$nestedData[] = $itemno;
			$nestedData[] = $vendor['itemdesc'];
			$nestedData[] = $vendor['unit_code'];
			$nestedData[] = $vendor['qty'];
			if (env('DEVICE_CODE') != "WAREHOUSE_ENCODER") {
				$warehouseQty = StockController::getStock($itemno,true,env('DB_CONFIG_WAREHOUSE_ENCODER'));
				if ($warehouseQty != false) {
					# code...
					$nestedData[] = $warehouseQty->qty;
				}else{
					$nestedData[] = "N/A";
				}
			}
            
            $nestedData[] = "₱ " . PriceController::getPrice($itemno)->price;

			

            $route = route('encodeitemno', ['encodeitemno' => $itemno]);
            
            $viewroute = route('viewitemtransactions', ['itemno' => $itemno]);

			$editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>New Transaction</span>
          </a>";

            $viewAction = "<a href='$viewroute' class='btn btn-info btn-icon-split btn-sm ml-4'>
            <span class='icon text-white-50'>
              <i class='fas fa-eye'></i>
            </span>
            <span class='text'>View Transaction</span>
          </a>";

			$nestedData[] = $editAction . $viewAction;
			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
	}


	public function admingetAll(Request $request)
	{
		$itemListView = new ItemList();


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
			$renesQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_RENES_ENCODER')));
			$redorQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_REDOR_ENCODER')));
			$warehouseQty = $this->ifNull(StockController::getStock($itemno,true,env('DB_CONFIG_WAREHOUSE_ENCODER')));

			$nestedData[] = $renesQty;
			$nestedData[] = $redorQty;
			$nestedData[] = $warehouseQty;

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

			
			$conditionRenes = $this->hasStock($renesQty);
			$conditionRedor = $this->hasStock($redorQty);
			$conditionWarehouse = $this->hasStock($warehouseQty);



			$info = array();
			$info['itemno'] = $itemno;
			$info['conditionRenes'] = $conditionRenes;
			$info['conditionRedor'] = $conditionRedor;
			$info['conditionWarehouse'] = $conditionWarehouse;

			$additionalInfo[] = $info;

			// if ($conditionRenes || $conditionRedor || $conditionWarehouse) {
			// 	$data[] = $nestedData;
			// }

			$data[] = $nestedData;

		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data,$additionalInfo);
	}

	public function ifNull($stock)
	{
		if ($stock == null || $stock == false) {
			return "N/A";
		}else{
			return $stock->qty;
		}
	}

	public function hasStock($qty)
	{
		if ($qty != "N/A") {
			if ($qty > 0) {
				return true;
			}else{
				return false;
			}
		} else {
			return false;
		}
	}

}
