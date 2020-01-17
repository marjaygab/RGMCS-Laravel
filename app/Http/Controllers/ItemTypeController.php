<?php

namespace App\Http\Controllers;

use App\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    //
    public static function getItemTypes(){
        $units = new ItemType();
        $units->setConnection(env('DB_CONFIG_REFERENCES'));
        $result = $units->get(['id','type']);
        return $result;
    }

    public static function generateOptionString($itemtypeid = null){

        $data = self::getItemTypes();

        if ($itemtypeid == null) {
            $string = "<option value ='0' disabled selected>--Select Item Type--</option>";
            foreach ($data as $key => $value) {
                $string .= "<option value = '$value->id'>$value->type</option>";
            }
        } else {
            $string = "<option value ='0' disabled>--Select Item Type--</option>";
            foreach ($data as $key => $value) {
                if ($value->id == $itemtypeid) {
                    $string .= "<option value = '$value->id' selected>$value->type</option>";
                } else{
                    $string .= "<option value = '$value->id'>$value->type</option>";
                }
            }
        }

        return $string;
    }
}
