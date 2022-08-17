<?php

namespace App\Http\Controllers;

use App\ItemBin;
use App\ItemCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemCatalogController extends Controller
{
    public function index()
    {
        $toPass = [
            "unit_options"=>UnitController::generateOptionString(),
            'type_options'=>ItemTypeController::generateOptionString(),
            'toEditItemDesc'=>''
        ];
        return view('addedititem',$toPass);
    }

    public function editItem(Request $request)
    {
        $itemno = $request->route('edititemno');
        $item = self::getItem($itemno);

        $toPass = [
            "unit_options"=>UnitController::generateOptionString($item->unit_id),
            'type_options'=>ItemTypeController::generateOptionString($item->item_type_id),
            'edititemno'=>$itemno,
            'toEditItemDesc'=>$item->itemdesc
        ];

        return view('addedititem',$toPass);
    }


    public function getOptionsStringRequest(Request $request)
    {
        $itemno = $request->get('itemno');
        $response = array();

        $string = self::generateOptionString($itemno);

        return json_encode([
            "optionsString"=>$string
        ]);
    }


    public static function generateOptionString($itemno=null){

        $items = self::getItems($itemno);
        $allItems = self::getItems(null,null,['itemdesc','ASC']);
        if ($itemno == null) {
            $string = "<option value ='0' disabled selected>--Select Item--</option>";
            foreach ($allItems as $key => $value) {
                $string .= "<option value = '$value->id'>$value->itemdesc</option>";
            }
        } else {
            $string = "<option value ='0' disabled>--Select Unit--</option>";
            foreach ($allItems as $key => $value) {
                if ($value->id == $itemno) {
                    $string .= "<option value = '$value->id' selected>$value->itemdesc</option>";
                } else{
                    $string .= "<option value = '$value->id'>$value->itemdesc</option>";
                }
            }
        }
        return $string;
    }


    public function updateItem(Request $request)
    {
        $itemno = $request->route('edititemno');

        $itemdesc = $request->post('itemdesc');
        $unit_id = $request->post('unit');
        $item_type_id = $request->post('itemtype');

        $parameters = [
            'itemdesc'=>$itemdesc,
            'unit_id'=>$unit_id,
            'item_type_id'=>$item_type_id
        ];

        $success = self::setItem($itemno,$parameters);

        $toPass = [
            "unit_options"=>UnitController::generateOptionString(),
            'type_options'=>ItemTypeController::generateOptionString(),
            'toEditItemDesc'=>''
        ];
        if ($success > 0) {
            return redirect('/items')->with($toPass);
        } else {
            return redirect('/items')->withErrors(['msg'=>"No item updated."])->with($toPass);
        }
        
    }


    public function getAll(Request $request)
    {
        $items = new ItemCatalog();
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
            $addtype = "1".substr($item['item_type'],0,1)."1";
            $idnum = $addtype .  str_pad($item["itemno"], 6, '0', STR_PAD_LEFT);

            $nestedData[] = $idnum;
            $nestedData[] = $item["itemdesc"];
            $nestedData[] = $item["unit"];
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

            $markAction = "<form action='$markRoute' method='POST'>
            <input class='btn btn-danger btn-sm mt-2 d-inline' type='submit' value='Mark Item'>
            <input type='hidden' name='_token' value='$csrf'>
            </form>";

            $nestedData[] = $editAction . $markAction;
            $data[] = $nestedData;
        }

        return DataTablesController::generateJson(intval( $request->post('draw')),intval( $result['total'] ),intval( $result['totalFiltered'] ),$data);
    }
    


    public static function getItem($itemno)
    {
        $itemCatalog = new  ItemCatalog();
        $itemCatalog->setConnection(env('DB_CONFIG_REFERENCES'));
        $item = $itemCatalog->where('id',$itemno)->first();
        if ($item != null) {
            return $item;
        }else{
            return false;
        }
        DB::disconnect();
    }

    public static function getItems($itemno = null,$first = false,$orderBy = null)
    {
        if ($itemno != null) {
            $params = ['id'=>$itemno];
        }else{
            $params = null;
        }

        $result = RGMCSFactory::fetchRows(new ItemCatalog(),env('DB_CONFIG_REFERENCES'),$params,$first,$orderBy);

        if ($result != null) {
            return $result;
        }else{
            return false;
        }
    }

    public static function getAllItem()
    {
        $itemCatalog = new  ItemCatalog();
        $itemCatalog->setConnection(env('DB_CONFIG_REFERENCES'));
        $item = $itemCatalog->all();
        if ($item != null) {
            return $item;
        }else{
            return false;
        }
        DB::disconnect();
    }

    public static function setItem($itemno,$parameters)
    {
        $itemCatalog = new ItemCatalog();
        $itemCatalog->setConnection(env('DB_CONFIG_REFERENCES'));
        $success = $itemCatalog->where('id',$itemno)
        ->update($parameters);

        return $success;
        
    }

    public static function insertItem($parameters)
    {
        $itemCatalog = new ItemCatalog();
        $itemCatalog->setConnection(env('DB_CONFIG_REFERENCES'));
        $success = $itemCatalog->insert($parameters);
        return $success;   
    }

    public function createItem(Request $request)
    {
        $success = self::insertItem([
            'itemdesc'=>$request->post('itemdesc'),
            'unit_id'=>$request->post('unit'),
            'item_type_id'=>$request->post('itemtype')
        ]);

        $toPass = [
            "unit_options"=>UnitController::generateOptionString(),
            'type_options'=>ItemTypeController::generateOptionString(),
            'toEditItemDesc'=>''
        ];
        if ($success > 0) {
            return redirect('/items')->with($toPass);
        } else {
            return redirect('/items')->withErrors(['msg'=>"No item inserted."])->with($toPass);
        }
    }


    public function deleteItemsFromBin()
    {
        $itemBin = new ItemBin();
        $binContents = RGMCSFactory::fetchRows($itemBin,env('DB_CONFIG_REFERENCES'),null,null);
        
        foreach ($binContents as $key => $value) {
            RGMCSFactory::deleteRows(new ItemCatalog(),env('DB_CONFIG_REFERENCES'),['id'=>$value->itemno]);
        }

        $itemBinController = new ItemBinController();
        $itemBinController->clearItem();

        return back();
    }
}
