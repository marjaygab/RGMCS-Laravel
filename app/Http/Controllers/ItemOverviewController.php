<?php

namespace App\Http\Controllers;

use App\ItemOverview;
use Illuminate\Http\Request;

class ItemOverviewController extends Controller
{
	//

	public function getAll(Request $request)
	{
		$itemOverview = new ItemOverview();

		$result = DataTablesController::generateResult(
			$request,
			$itemOverview,
			env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),
			['itemno', 'itemdesc', 'unit_code', 'qty', 'action'],
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

			$route = route('encodeitemno', ['encodeitemno' => $itemno]);

			$editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>New Transaction</span>
          </a>";

			$nestedData[] = $editAction;
			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
	}
}
