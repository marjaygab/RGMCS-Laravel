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
        $row = $accessLevel->setConnection(env('DB_CONFIG_REFERENCES'))->where(['id'=>$id])->first();
        $code = $row->code;
        return $code;
    }
}
