<?php

namespace App\Http\Controllers;

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
			$nestedData[] = $vendor['id'];
			$nestedData[] = $vendor['itemdesc'];
            $nestedData[] = $vendor['unit_code'];
			$nestedData[] = $vendor['qty'];
            $itemno = $vendor['id'];
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

}
