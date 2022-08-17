<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\ReceiptItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use stdClass;

class ReceiptController extends Controller
{
    //

   
    public function fetchDateRange(Request $request)
    {
        $dateRangeResponse = self::getDateRange();

        $response = array();
        $response['from'] = $dateRangeResponse->fromDate;
        $response['to'] = $dateRangeResponse->toDate;

        return json_encode($response);
    }

    public static function getDateRange()
    {
        $dateRangeResponse = new stdClass();

        $earliest = RGMCSFactory::fetchRows(new Receipt(),env('DB_CONIG_RENES_ADMIN'),null,true,['tdate','desc']);
        $oldest = RGMCSFactory::fetchRows(new Receipt(),env('DB_CONIG_RENES_ADMIN'),null,true,['tdate','asc']);

        if ($earliest == null || $oldest == null) {
            $earliest = Carbon::now()->toDateString();
            $oldest = $earliest;
        }


        $dateRangeResponse->fromDate = $oldest->tdate;
        $dateRangeResponse->toDate = $earliest->tdate;

        return $dateRangeResponse;
    }

    public function updateReceipt(Request $request)
    {
        $parameters = [
            'vid'=>$request->post('vid'),
            'vendor'=>VendorController::getVendor($request->post('vid'),true)->vendor,
            'tdate'=>$request->post('tdate'),
            'total'=>$request->post('total')
        ];

        $result = self::updateReceiptDetails($request->post('receipt_no'),$parameters);

        if ($result) {
            return back();
        }else{
            return back()->withErrors(['msg'=>'An error occured in updating receipt.']);
        }
    }



    public static function updateReceiptDetails($receipt_no,$parameters)
    {
        $result = RGMCSFactory::updateRows(new Receipt(),env('DB_CONFIG_RENES_ADMIN'),['id'=>$receipt_no],$parameters);

        return $result > 0;
    }

    public static function recalculateTotal($receipt_no)
    {
        $total = ReceiptItemsController::getTotal($receipt_no);
        $parameters = [
            'total'=>$total
        ];

        $result = self::updateReceiptDetails($receipt_no,$parameters);

        return $result;
    }


    public static function newReceipt($tDate,$vid,$vendor,$total)
    {
        $parameters=  [
            "tdate"=>$tDate,
            "vid"=>$vid,
            "vendor"=>$vendor,
            "total"=>$total,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];

        $result = RGMCSFactory::insertRowsId(new Receipt(),env('DB_CONFIG_RENES_ADMIN'),$parameters);

        return $result;
    }

    public function getReceiptJson(Request $request)
    {
        $receipt_id = $request->route('receipt_id');
        $result = self::getReceipt($receipt_id,true,true);
        if ($result != false) {
            return json_encode($result);
        }else{
            return json_encode([
                'receipt_id'=>$receipt_id,
                'success'=>false
            ]);
        }
    }





    public static function getReceipt($receipt_id = null,$wItems = false,$first = true)
    {
        $receiptObject = array();
        if ($first) {
            // Only get one
            $result = RGMCSFactory::fetchRows(new Receipt(),env('DB_CONFIG_RENES_ADMIN'),['id'=>$receipt_id],true);
            if ($result != false) {
                $receiptObject['receipt'] = $result;
                if ($wItems) {
                    $result = RGMCSFactory::fetchRows(new ReceiptItems(),env('DB_CONFIG_RENES_ADMIN'),['receipt_id'=>$receiptObject['receipt']->id],false);

                    if ($result != false) {
                        $receiptObject['receipt_items'] = $result;
                    }else{
                        $receiptObject['receipt_items'] = [];
                    }

                    return $receiptObject;
                }
            }else{
                return false;
            }

        }else{
            // Get All
            $result = RGMCSFactory::fetchRows(new Receipt(),env('DB_CONFIG_RENES_ADMIN'));

            $receiptObject['receipts'] = $result;
            return $receiptObject;
        }
    }



    public function getAll(Request $request)
	{
        $receipt = new Receipt();

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
            $receipt,
            env("DB_CONFIG_RENES_ADMIN"),
            [
                'id',
                'tdate',
                'vendor', 
                'total',
                'action'
            ],
            'vendor',
            null,
            ['tdate',[$fromDate,$toDate]]
        );

		$data = array();
		foreach ($result['result'] as $key => $receipt) {
            $nestedData = array();
            $receipt_id = $receipt['id'];

			$nestedData[] = $receipt_id;
            // $nestedData[] = date_format($receipt['tdate'],"Y/m/d h:i A");

            $tDate = strtotime($receipt['tdate']);
            $nestedData[] = date("Y/m/d",$tDate);

            $nestedData[] = $receipt['vendor'];
            $nestedData[] = "₱ " . $receipt['total'];
            // $nestedData[] = date_format($receipt['created_at'],"Y/m/d h:i A");

            $route = route('edit-notebook',['receipt_id'=>$receipt_id]);

            $editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>Edit Receipt</span>
          </a>";

          $nestedData[] = $editAction;


		    $data[] = $nestedData;
		}
        
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
    }

}
