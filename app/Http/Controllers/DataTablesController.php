<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTablesController extends Controller
{
    //
    public static function generateResult(Request $request,$model,$dbConfig,array $columns,$whereParam,$additionalParam = null,$whereBetween = null)
    {
        $model->setConnection($dbConfig);
        $result = $model->get();

        $total = $result->count();
        $totalFiltered = $total;

        $base = $model;
        $partial = $base;

        if ($request->post("search")['value'] != null) {
            $searchValue = $request->post("search")['value'];

            $partial = $base->where($whereParam,'like','%' . $searchValue . '%');
            $base = $partial;

            if ($additionalParam != null) {
                $result = $partial
                ->orWhere($additionalParam)
                ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                ->get();
                
                $totalFiltered = $result->count();

                $partial = $base->orWhere([$additionalParam]);

                if ($whereBetween != null) {
                    $partial = $base->whereBetween($whereBetween[0],$whereBetween[1]);

                    $result = $partial
                    ->orWhere($additionalParam)
                    ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                    ->get();

                    $totalFiltered = $result->count();
                }

                $base = $partial;
            }else{
                $result = $partial
                ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                ->get();
                
                $totalFiltered = $result->count();

                if ($whereBetween != null) {
                    $partial = $base->whereBetween($whereBetween[0],$whereBetween[1]);

                    $result = $partial
                    ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                    ->get();
                    $totalFiltered = $result->count();
                    $base = $partial;
                }
            }

            $partial = $base
            ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir']);

            $base = $partial;
            
            if ($request->post('length') != -1) {
                $partial = $base
                ->offset($request->post("start"))
                ->limit($request->post("length"));
                $base = $partial;
            }

            $partial = $base->get();
            $base = $partial;

        } else {

            if ($additionalParam != null) {
                $partial = $base->where([$additionalParam]);

                if ($whereBetween != null) {
                    $partial = $base->orWhereBetween($whereBetween[0],$whereBetween[1]);
                    $result = $partial
                    ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                    ->get();
                    $totalFiltered = $result->count();

                }

                $base = $partial;
            }else{
                if ($whereBetween != null) {
                    $partial = $base->whereBetween($whereBetween[0],$whereBetween[1]);
                    $result = $partial
                    ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                    ->get();
                    $totalFiltered = $result->count();
                    $base = $partial;
                }
            }

            $partial = $base->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir']);
            $base = $partial;
            
            if ($request->post('length') != -1) {
                $partial = $base
                ->offset($request->post("start"))
                ->limit($request->post("length"));
                $base = $partial;
            }

            $partial = $base->get();
            $base = $partial;

        }

        $result = $base;
        
    
        DB::disconnect();

        return array(
            'result'=>$result,
            'total'=>$total,
            'totalFiltered'=>$totalFiltered
        );
    }

    public static function generateJson($draw,$recordsTotal,$recordsFiltered,$data,$additionaldata = null)
    {
        $json_data = array(
            "draw"            => intval( $draw),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $recordsTotal ),  // total number of records
            "recordsFiltered" => intval( $recordsFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data,   // total data array
            "additionaldata" => $additionaldata
        );

        return json_encode($json_data);
    }
}
