<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\VendorBin;
use Illuminate\Http\Request;

class VendorBinController extends Controller
{
    //
    public function getAll(Request $request)
    {
        $vendorBin = new VendorBin();
       
        $result = DataTablesController::generateResult($request,$vendorBin,env('DB_CONFIG_REFERENCES'),['vendor','vperson','created_at','action'],'vendor');

        $data = array();
        foreach ($result['result'] as $key => $vendor) {
            $nestedData=array(); 
            $nestedData[] = $vendor['vendor'];
            $nestedData[] = $vendor['vperson'];
            $vendorid = $vendor['vid'];
            $markRoute = route('unmarkvendor',['unmarkvendorid'=>$vendorid]);
            // $markRoute = '';

            $csrf = csrf_token();

            $markAction = "<form action='$markRoute' method='POST'>
            <input class='btn btn-danger btn-sm mt-2' type='submit' value='Remove'>
            <input type='hidden' name='_token' value='$csrf'>
            </form>";

            $nestedData[] =  $markAction;
            $data[] = $nestedData;
        }


        return DataTablesController::generateJson(intval( $request->post('draw')),intval( $result['total'] ),intval( $result['totalFiltered'] ),$data);
    }

    public function markVendor(Request $request)
    {
        $vid = $request->route('markvendorid');
        $vendorObj = VendorController::getVendor($vid,true);
        $parameters = array(
            'vid'=>$vid,
            'vendor'=>$vendorObj->vendor,
            'vperson'=>$vendorObj->vperson
        );

        return RGMCSFactory::mark(new VendorBin(),['vid'=>$vid],$parameters);
    }

    public function unmarkVendor(Request $request)
    {
        $vid = $request->route('unmarkvendorid');
        return RGMCSFactory::unmark(new VendorBin(),['vid'=>$vid]);
    }

    public function clearVendor()
    {
        $vendorBin = new VendorBin();
        return RGMCSFactory::clearBin($vendorBin);
    }

    
}
