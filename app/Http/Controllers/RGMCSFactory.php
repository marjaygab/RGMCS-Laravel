<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RGMCSFactory extends Controller
{
    //

    public static function connectDB($model,$dbConfigName)
    {
        $model->setConnection($dbConfigName);
        return $model;
    }

    public static function insertRows($model,$dbConfig,$parameters)
    {
        $result = self::connectDB($model,$dbConfig)->insert($parameters);

        DB::disconnect();
        return $result;
    }

    public static function insertRowsId($model,$dbConfig,$parameters)
    {
        $result = self::connectDB($model,$dbConfig)->insertGetId($parameters);

        DB::disconnect();
        return $result;
    }

    public static function updateRows($model,$dbConfig,$whereClause,$parameters)
    {
        $result =self::connectDB($model,$dbConfig)->where($whereClause)->update($parameters);
        DB::disconnect();

        return $result;
    }

    public static function deleteRows($model,$dbConfig,$whereClause)
    {
        $result = self::connectDB($model,$dbConfig)->where($whereClause)->delete();
        DB::disconnect();
        return $result;
    }

    public static function fetchRows($model,$dbConfig,$whereClause = null,bool $first = null)
    {
        if ($first != null) {
            if ($first) {
                if ($whereClause != null) {
                    $result =  self::connectDB($model,$dbConfig)->where($whereClause)->first();
                }else{
                    $result =  self::connectDB($model,$dbConfig)->first();
                }
            } else {
                if ($whereClause != null) {
                    $result =  self::connectDB($model,$dbConfig)->where($whereClause)->get();
                }else{
                    $result =  self::connectDB($model,$dbConfig)->get();
                }
            }
        } else {
            if ($whereClause != null) {
                $result =  self::connectDB($model,$dbConfig)->where($whereClause)->get();
            }else{
                $result =  self::connectDB($model,$dbConfig)->get();
            }
        }

        DB::disconnect();
        return $result;
    }

    public static function truncateRows($model,$dbConfig)
    {
        self::connectDB($model,$dbConfig)->truncate();
    }

    public static function mark($binModel,$keyParam,$parameters)
    {
        $result = self::fetchRows($binModel,env('DB_CONFIG_REFERENCES'),$keyParam,true);

        if ($result != null) {
            return back()->withErrors(['msg'=>'You already marked this item.']);
        }else{
            $result = self::insertRows($binModel,env('DB_CONFIG_REFERENCES'),$parameters);
            if ($result > 0) {
                return back();
            } else {
                return back()->withErrors(['msg'=>'An error occured while marking item']);
            }
        }
    }

    public static function unmark($binModel,$keyParam)
    {
        $result = RGMCSFactory::deleteRows($binModel,env('DB_CONFIG_REFERENCES'),$keyParam);

        if ($result > 0) {
            return back();
        }else{
            return back()->withErrors(['msg'=>'There was an error in unmarking item.']);
        }

    }

    public static function clearBin($binModel)
    {
        return self::clearTable($binModel,env('DB_CONFIG_REFERENCES'));
    }

    public static function clearTable($model,$environment)
    {
        self::truncateRows($model,$environment);
        return back();
    }

    public static function random($length = null)
    {
        return strtoupper(Str::random($length));
    }

}
