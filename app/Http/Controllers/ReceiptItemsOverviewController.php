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

        if($request->has('itemNo')){
            $itemNo = $inputParams['itemNo'];
        }else{
            $itemNo = null;
        }


        if($itemNo != null){
            $result = DataTablesController::generateResult(
                $request,
                $receiptItemsOverview,
                env("DB_CONFIG_RENES_ADMIN"),
                [
                    'receipt_no',
                    'tdate', 
                    'vendor',
                    'itemdesc',
                    'baseprice',
                    'd1',
                    'd2',
                    'd3',
                    'd4',
                    'netprice',
                    'action'     
                ],
                'itemdesc',
                ['itemno','=',$itemNo],
                ['tdate',[$fromDate,$toDate]]
            );
        }else{
            $result = DataTablesController::generateResult(
                $request,
                $receiptItemsOverview,
                env("DB_CONFIG_RENES_ADMIN"),
                [
                    'receipt_no',
                    'tdate', 
                    'vendor',
                    'itemdesc',
                    'baseprice',
                    'd1',
                    'd2',
                    'd3',
                    'd4',
                    'netprice',
                    'action'     
                ],
                'itemdesc',
                null,
                ['tdate',[$fromDate,$toDate]]
            );
        }


		$data = array();
		foreach ($result['result'] as $key => $receipt) {
            $nestedData = array();
            $receipt_no = $receipt['receipt_no'];
            $receipt_item_no = $receipt['receipt_item_no'];
            $nestedData[] = $receipt_no;

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

            $route = route('edit-notebook',['receipt_id'=>$receipt_no]);

            $editAction = "<button class='btn btn-primary btn-icon-split btn-sm receipt-items-edit' value='$receipt_item_no' receipt-no='$receipt_no' data-toggle='modal' data-target='#editReceiptItemModal'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>Edit Item</span>
          </button>";

            $nestedData[] = $editAction;


			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
    }
}
