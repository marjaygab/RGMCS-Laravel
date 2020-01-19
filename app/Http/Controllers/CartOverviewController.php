<?php

namespace App\Http\Controllers;

use App\CartOverview;
use Illuminate\Http\Request;

class CartOverviewController extends Controller
{
    //


    public static function getCartOverviewItem($cartid = null,$first = null)
    {
        if ($cartid != null) {
            $parameters = ['id'=>$cartid];
        }else{
            $parameters = null;
        }

        $result = RGMCSFactory::fetchRows(new CartOverview(),env("DB_CONFIG_" . env('DEVICE_CODE') . "_DB"),$parameters,$first);

        return $result;
    }


    public function getAll(Request $request)
	{
		$itemOverview = new CartOverview();

		$result = DataTablesController::generateResult(
			$request,
			$itemOverview,
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
                'tdate',
                'created_at',
                'action'
            ],
			'itemdesc'
		);

		$data = array();
		foreach ($result['result'] as $key => $cartitem) {
			$nestedData = array();
			$nestedData[] = $cartitem['itemno'];
            $nestedData[] = $cartitem['transaction_type'];
            $nestedData[] = $cartitem['name'];
            $nestedData[] = $cartitem['itemdesc'];
            $nestedData[] = $cartitem['vendor'];
            $nestedData[] = $cartitem['unit_cost'];
            $nestedData[] = $cartitem['qtyin'];
            $nestedData[] = $cartitem['qtyout'];
            $nestedData[] = $cartitem['tdate'];
            $nestedData[] = date_format($cartitem['created_at'],"Y/m/d h:i A");

            $cartid = $cartitem['id'];

			$route = route('removecartitem', ['cartid' => $cartid]);

			$editAction = "<a href='$route' class='btn btn-danger btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>Remove</span>
          </a>";

			$nestedData[] = $editAction;
			$data[] = $nestedData;
		}
		return DataTablesController::generateJson(intval($request->post('draw')), intval($result['total']), intval($result['totalFiltered']), $data);
	}
}
