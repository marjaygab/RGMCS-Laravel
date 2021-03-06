<?php

namespace App\Http\Controllers;

use App\ItemList;
use Illuminate\Http\Request;

class ItemListController extends Controller
{
    //

    public function getAll(Request $request)
    {
        $items = new ItemList();
        $result = DataTablesController::generateResult(
            $request,
            $items,
            env('DB_CONFIG_REFERENCES'),
            ['itemno','itemdesc','unit','action'],
            'itemdesc'
        );

        $data=array();
        foreach ($result['result'] as $key => $item) {
            $nestedData=array(); 
            $addtype = "1".substr($item['type'],0,1)."1";
            $idnum = $addtype .  str_pad($item["id"], 6, '0', STR_PAD_LEFT);

            $nestedData[] = $idnum;
            $nestedData[] = $item["itemdesc"];
            $nestedData[] = $item["unit_code"];
            $id = $item['id'];
            $route = route('edititems',['edititemno'=>$id]);
            $editAction = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
            <span class='icon text-white-50'>
              <i class='fas fa-edit'></i>
            </span>
            <span class='text'>Edit Item</span>
          </a>";

          $markRoute = route('markitem',['markitemno'=>$id]);
          $csrf = csrf_token();

            $markAction = "<form action='$markRoute' method='POST' class='d-inline'>
            <input class='btn btn-danger btn-sm' type='submit' value='Mark Item'>
            <input type='hidden' name='_token' value='$csrf'>
            </form>";

            $nestedData[] = $editAction . $markAction;
            $data[] = $nestedData;
        }

        return DataTablesController::generateJson(intval( $request->post('draw')),intval( $result['total'] ),intval( $result['totalFiltered'] ),$data);
    }

    public static function getItem($itemno)
    {
        $itemList = new  ItemList();
        $item = RGMCSFactory::fetchRows($itemList,env('DB_CONFIG_REFERENCES'),['id'=>$itemno],true);
        if ($item != null) {
            return $item;
        }else{
            return false;
        }
    }

  
    



}
