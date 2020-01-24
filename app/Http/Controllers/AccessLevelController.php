<?php

namespace App\Http\Controllers;

use App\AccessLevel;
use Illuminate\Http\Request;

class AccessLevelController extends Controller
{
    //
    public static function checkAccessLevel($id)
    {
        $accessLevel = new AccessLevel();
        $result = RGMCSFactory::fetchRows($accessLevel,env('DB_CONFIG_REFERENCES'),['id'=>$id],true);
        // $row = $accessLevel->setConnection()->where(['id'=>$id])->first();
        $code = $result->code;
        return $code;
    }
}
