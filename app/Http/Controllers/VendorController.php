<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\VendorBin;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('addeditvendor');
    }

    public function editVendor(Request $request)
    {
        $vid = $request->route('editvendorid');
        $vendor = RGMCSFactory::fetchRows(new Vendor(),env('DB_CONFIG_REFERENCES'),['id'=>$vid],true);

        $toPass = [
            'editvendorid'=>$vendor->vid,
            'vid'=>$vendor->vid,
            'vendor'=>$vendor->vendor,
            'vperson'=>$vendor->vperson,
            'vaddress'=>$vendor->vaddress,
            'vcontact'=>$vendor->vcontact,
        ];

        return view('addeditvendor',$toPass);
    }

    public function updateVendor(Request $request)
    {
        $vid = $request->route('editvendorid');

        $vendor = $request->post('vendor');
        $vperson = $request->post('vperson');
        $vaddress = $request->post('vaddress');
        $vcontact = $request->post('vcontact');

        $parameters = [
            'vendor'=>$vendor,
            'vperson'=>$vperson,
            'vaddress'=>$vaddress,
            'vcontact'=>$vcontact,
        ];

        $success = RGMCSFactory::updateRows(new Vendor(),env('DB_CONFIG_REFERENCES'),['id'=>$vid],$parameters);

        if ($success > 0) {
            return redirect('/vendors');
        } else {
            return redirect('/vendors')->withErrors(['msg'=>"No Vendor updated."]);
        }
        
    }

    public static function getVendor($vid = null,$first = null,$orderBy = null)
    {
        
        if ($vid == null) {
            $parameters = null;
        }else{
            $parameters = ['id'=>$vid];
        }

        $result = RGMCSFactory::fetchRows(new Vendor(),env('DB_CONFIG_REFERENCES'),$parameters,$first,$orderBy);

        if ($result != null) {
            return $result;
        }else{
            return false;
        }

    }

    


    public function createVendor(Request $request)
    {

        $parameters = [
            'vendor'=>$request->post('vendor'),
            'vperson'=>$request->post('vperson'),
            'vaddress'=>$request->post('vaddress'),
            'vcontact'=>$request->post('vcontact'),
        ];

        $success = RGMCSFactory::insertRows(new Vendor(),env('DB_CONFIG_REFERENCES'),$parameters);

        if ($success > 0) {
            return redirect('/vendors');
        } else {
            return redirect('/vendors')->withErrors(['msg'=>"No vendor inserted."]);
        }
    }


    public function deleteVendorsFromBin()
    {
        $vendorBin = new VendorBin();
        $binContents = RGMCSFactory::fetchRows($vendorBin,env('DB_CONFIG_REFERENCES'),null,null);
        
        foreach ($binContents as $key => $value) {
            echo $value->vid;
            RGMCSFactory::deleteRows(new Vendor(),env('DB_CONFIG_REFERENCES'),['id'=>$value->vid]);
        }

        $vendorBinController = new VendorBinController();
        $vendorBinController->clearVendor();

        return back();
    }

    public static function generateOptionString($vid=null){

        $data = self::getVendor(null,null,['vendor','ASC']);

        if ($vid == null) {
            $string = "<option value ='0' disabled selected>--Select Unit--</option>";
            foreach ($data as $key => $value) {
                $string .= "<option value = '$value->id'>$value->vendor</option>";
            }
        } else {
            $string = "<option value ='0' disabled>--Select Unit--</option>";
            foreach ($data as $key => $value) {
                if ($value->id == $vid) {
                    $string .= "<option value = '$value->id' selected>$value->vendor</option>";
                } else{
                    $string .= "<option value = '$value->id'>$value->vendor</option>";
                }
            }
        }
        

        return $string;
    }

    public function getAll(Request $request)
    {
        $vendors = new Vendor();

        $result = DataTablesController::generateResult(
            $request,
            $vendors,
            env('DB_CONFIG_REFERENCES'),
            ['vendor','vperson','vaddress','vcontact','action'],
            'vendor'
        );
        
        foreach ($result['result'] as $key => $vendor) {
            $nestedData=array(); 
            $nestedData[] = $vendor['vendor'];
            $nestedData[] = $vendor['vperson'];
            $nestedData[] = $vendor['vaddress'];
            $nestedData[] = $vendor['vcontact'];
            $vendorid = $vendor['id'];
            $route = route('editvendors',['editvendorid'=>$vendorid]);
            $markRoute = route('markvendor',['markvendorid'=>$vendorid]);

            $editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>Edit Vendor</span>
          </a>";

            $csrf = csrf_token();

            $markAction = "<form action='$markRoute' method='POST' class='d-inline'>
            <input class='btn btn-danger btn-sm' type='submit' value='Mark Vendor'>
            <input type='hidden' name='_token' value='$csrf'>
            </form>";
            $nestedData[] = $editAction . $markAction;
            $data[] = $nestedData;
        }
        return DataTablesController::generateJson(intval( $request->post('draw')),intval( $result['total'] ),intval( $result['totalFiltered'] ),$data);
    }
}
