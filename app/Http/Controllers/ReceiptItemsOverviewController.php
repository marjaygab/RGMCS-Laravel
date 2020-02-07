<?php

namespace App\Http\Controllers;

use App\ReceipItemsOverview;
use App\ReceiptItemsOverview;
use Illuminate\Http\Request;

class ReceiptItemsOverviewController extends Controller
{
    public function getAll(Request $request)
	{
        $receiptItemsOverview = new ReceiptItemsOverview();

        $inputParams = $request->all();

        if ($request->has('fromDate') && $request->has('toDate')) {
            $fromDate = $inputParams['fromDate'];
            $toDate = $inputParams['toDate'];

        }else{
            $ranges = ReceiptController::getDateRange();
            $fromDate = $ranges->fromDate;
            $toDate = $ranges->toDate;
        }

        $result = DataTablesController::generateResult(
            $request,
            $receiptItemsOverview,
            env("DB_CONFIG_RENES_ADMIN"),
            [
                'id',
                'tdate', 
                'vendor',
                'itemdesc',
                'baseprice',
                'd1',
                'd2',
                'd3',
                'd4',
                'netprice'      
            ],
            'itemdesc',
            null,
            ['tdate',[$fromDate,$toDate]]
        );

		$data = array();
		foreach ($result['result'] as $key => $receipt) {
			$nestedData = array();
            $nestedData[] = $receipt['id'];
            // $nestedData[] = date_format($receipt['tdate'],"Y/m/d h:i A");

            $tDate = strtotime($receipt['tdate']);
            $nestedData[] = date("Y/m/d",$tDate);
            $nestedData[] = $receipt['vendor'];
            $nestedData[] = $receipt['itemdesc'];
            $nestedData[] = "₱ " . $receipt['baseprice'];
            $nestedData[] = $receipt['d1'];
            $nestedData[] = $receipt['d2'];
            $nestedData[] = $receipt['d3'];
            $nestedData[] = $receipt['d4'];
            $nestedData[] = "₱ " . $receipt['netprice'];
            // $nestedData[] = date_format($receipt['created_at'],"Y/m/d h:i A");

            // $route = route('edit-notebook');

        //     $editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
        //     <span class='icon text-white-50'>
        //       <i class='fas fa-edit'></i>
        //     </span>
        //     <span class='text'>Edit Item</span>
        //   </a>";


			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
    }
}
