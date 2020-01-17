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

    public static function getItem($itemno)
    {
        $itemCatalog = new  ItemCatalog();
        $itemCatalog->setConnection(env('DB_CONFIG_REFERENCES'));
        $item = $itemCatalog->where('itemno',$itemno)->first();
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
        $success = $itemCatalog->where('itemno',$itemno)
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
            RGMCSFactory::deleteRows(new ItemCatalog(),env('DB_CONFIG_REFERENCES'),['itemno'=>$value->itemno]);
        }

        $itemBinController = new ItemBinController();
        $itemBinController->clearItem();

        return back();
    }
}
