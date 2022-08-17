<?php

namespace App\Http\Controllers;

use App\ReceiptItemsAggregated;
use Illuminate\Http\Request;

class ReceiptItemsAggregatedController extends Controller
{
    public function getAll(Request $request)
	{
        $receiptItemsAggregated = new ReceiptItemsAggregated();

        
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
            $receiptItemsAggregated,
            env("DB_CONFIG_RENES_ADMIN"),
            [
                'itemno',
                'itemdesc', 
                'latest_submission_date',
                'action'     
            ],
            'itemdesc',
            null,
            ['latest_submission_date',[$fromDate,$toDate]]
        );

		$data = array();
		foreach ($result['result'] as $key => $aggregatedItem) {
            $nestedData = array();
            // $receipt_no = $receipt['receipt_no'];
            // $receipt_item_no = $receipt['receipt_item_no'];
            // $nestedData[] = $receipt_no;

            // $nestedData[] = date_format($receipt['tdate'],"Y/m/d h:i A");

            $itemNo = $aggregatedItem['itemno'];
            $latestSubmissionDate = strtotime($aggregatedItem['latest_submission_date']);
            $nestedData[] = $itemNo;
            $nestedData[] = $aggregatedItem['itemdesc'];
            $nestedData[] = date("Y/m/d",$latestSubmissionDate);
            
            
    
            // $nestedData[] = date_format($receipt['created_at'],"Y/m/d h:i A");

            // $route = route('edit-notebook',['receipt_id'=>$receipt_no]);

            $moreInformation = "<a href='/notebook/item/". $itemNo ."' class='btn btn-info btn-icon-split btn-sm receipt-aggregate-info' id='$itemNo' value='$itemNo'>
            <span class='icon text-white-50'>
              <i class='fas fa-info'></i>
            </span>
            <span class='text'>View As Receipt Item</span>
          </a>";

            $nestedData[] = $moreInformation;


			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
    }
}
