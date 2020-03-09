<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    public static function fetchRows($model,$dbConfig,$whereClause = null,bool $first = null,$orderClause = null)
    {

        $base = self::connectDB($model,$dbConfig);
        $partial = $base;

        if ($whereClause != null) {
            $partial = $base->where($whereClause);
            $base = $partial;
        }

        if ($orderClause != null) {
            $partial = $base->orderBy($orderClause[0],$orderClause[1]);
            $base = $partial;
        }

        if ($first != null) {
            if ($first) {
                $partial = $base->first();
            }else{
                $partial = $base->get();
            }
        }else{
            $partial = $base->get();
        }


        $base = $partial;
        
        // if ($first != null) {
        //     if ($first) {
        //         if ($whereClause != null) {
        //             $result =  self::connectDB($model,$dbConfig)->where($whereClause)->first();
        //         }else{
        //             $result =  self::connectDB($model,$dbConfig)->first();
        //         }
        //     } else {
        //         if ($whereClause != null) {
        //             $result =  self::connectDB($model,$dbConfig)->where($whereClause)->get();
        //         }else{
        //             $result =  self::connectDB($model,$dbConfig)->get();
        //         }
        //     }
        // } else {
        //     if ($whereClause != null) {
        //         $result =  self::connectDB($model,$dbConfig)->where($whereClause)->get();
        //     }else{
        //         $result =  self::connectDB($model,$dbConfig)->get();
        //     }
        // }


        DB::disconnect();
        return $base;
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

    public static function countFromArray(Array $list , $condition)
    {
        $counter = 0;
        foreach ($list as $item) {
            if ($item == $condition) {
                $counter++;
            }
        }
        
        return $counter;
    }

    public static function getGreetings($user = "")
    {
        $now = Carbon::now();
        

        $morningRange = [
            "from"=>Carbon::create($now->year,$now->month,$now->day,0,0,0),
            "to"=>Carbon::create($now->year,$now->month,$now->day,11,59,0),
            "greeting"=>"Good Morning $user!",
            "image"=>asset('img/undraw_morning_work.svg')
        ];

        $afterNoonRange = [
            "from"=>Carbon::create($now->year,$now->month,$now->day,12,0,0),
            "to"=>Carbon::create($now->year,$now->month,$now->day,16,59,0),
            "greeting"=>"Good Afternoon $user!",
            "image"=>asset('img/undraw_afternoon_work.svg')
        ];

        $eveningRange = [
            "from"=>Carbon::create($now->year,$now->month,$now->day,17,0,0),
            "to"=>Carbon::create($now->year,$now->month,$now->day,23,59,0),
            "greeting"=>"Good Evening $user!",
            "image"=>asset('img/undraw_evening_work.svg')
        ];

        $timeRanges = [
            $morningRange,
            $afterNoonRange,
            $eveningRange
        ];

        foreach ($timeRanges as $range) {
            if($now->between($range['from'],$range['to'])){
                return [
                    "greeting"=>$range['greeting'],
                    "image"=>$range['image']
                ];
            }
        }

        return [
            "greeting"=>"Good Day $user!",
            "image"=>asset('img/undraw_morning_work.svg')
        ];;
    }

}
