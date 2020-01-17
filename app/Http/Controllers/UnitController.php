<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    public static function getUnits(){
        $units = new Unit();
        $units->setConnection(env('DB_CONFIG_REFERENCES'));
        $result = $units->get(['id','unit_code']);
        return $result;
    }

    public static function generateOptionString($unitid=null){

        $data = self::getUnits([]);

        if ($unitid == null) {
            $string = "<option value ='0' disabled selected>--Select Unit--</option>";
            foreach ($data as $key => $value) {
                $string .= "<option value = '$value->id'>$value->unit_code</option>";
            }
        } else {
            $string = "<option value ='0' disabled>--Select Unit--</option>";
            foreach ($data as $key => $value) {
                if ($value->id == $unitid) {
                    $string .= "<option value = '$value->id' selected>$value->unit_code</option>";
                } else{
                    $string .= "<option value = '$value->id'>$value->unit_code</option>";
                }
            }
        }
        

        return $string;
    }
}
