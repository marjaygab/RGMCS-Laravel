<?php

namespace App\Http\Controllers;

use App\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    //


 public static function getTransactionType($tid = null,$first = null)
    {
        
        $result = RGMCSFactory::fetchRows(new TransactionType(),env('DB_CONFIG_REFERENCES'),$tid,$first);

        if ($result != null) {
            return $result;
        }else{
            return false;
        }

    }

    public static function getFlow($description)
    {
        $parameters = ['description'=>$description];

        $result = RGMCSFactory::fetchRows(new TransactionType(),env('DB_CONFIG_REFERENCES'),$parameters,true);
        
        if ($result['flow'] == null) {
            return false;
        }else{
            return $result['flow'];
        }
    }

    public static function generateOptionString($vid=null){

        $data = self::getTransactionType(null,null);

        if ($vid == null) {
            $string = "<option value ='0' disabled selected>--Select Type--</option>";
            foreach ($data as $key => $value) {
                if (self::isPermitted($value->access)) {
                    # code...
                    $string .= "<option value = '$value->id'>$value->description</option>";
                }
            }
        } else {
            $string = "<option value ='0' disabled>--Select Type--</option>";
            foreach ($data as $key => $value) {
                if (self::isPermitted($value->access)) {
                    if ($value->id == $vid) {
                        $string .= "<option value = '$value->id' selected>$value->description</option>";
                    } else{
                        $string .= "<option value = '$value->id'>$value->description</option>";
                    }
                }
            }
        }
        

        return $string;
    }

    public static function isPermitted($access)
    {
        return strpos($access,env('DEVICE_CODE')) !== false;
    }

    

}
