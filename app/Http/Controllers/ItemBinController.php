<?php

namespace App\Http\Controllers;

use App\ItemBin;
use App\ItemList;
use Illuminate\Http\Request;

class ItemBinController extends Controller
{
    //

    public function getAll(Request $request)
    {
        $itemBin = new itemBin();
       
        $result = DataTablesController::generateResult($request,$itemBin,env('DB_CONFIG_REFERENCES'),['itemno','itemdesc','created_at','action'],'itemdesc');

        $data = array();
        foreach ($result['result'] as $key => $item) {
            $nestedData=array(); 
            $nestedData[] = $item['itemdesc'];
            $itemno = $item['itemno'];
            $markRoute = route('unmarkitem',['unmarkitemno'=>$itemno]);
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

    public function markItem(Request $request)
    {
        $itemno = $request->route('markitemno');    
        $itemObj = ItemListController::getItem($itemno);
        $parameters = array(
            'itemno'=>$itemno,
            'itemdesc'=>$itemObj->itemdesc,
        );

        return RGMCSFactory::mark(new ItemBin(),['itemno'=>$itemno],$parameters);
    }

    public function unmarkItem(Request $request)
    {
        $itemno = $request->route('unmarkitemno');
        return RGMCSFactory::unmark(new ItemBin(),['itemno'=>$itemno]);
    }

    public function clearItem()
    {
        $itemBin = new ItemBin();
        return RGMCSFactory::clearBin($itemBin);
    }
}
