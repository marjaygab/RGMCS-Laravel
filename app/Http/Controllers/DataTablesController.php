<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTablesController extends Controller
{
    //
    public static function generateResult(Request $request,$model,$dbConfig,array $columns,$whereParam)
    {
        $model->setConnection($dbConfig);
        $result = $model->get();
        // $result = RGMCSFactory::connectDB($items,env('DB_CONFIG_REFERENCES'))->get();

        $data = array();

        $total = $result->count();
        $totalFiltered = $total;

        if ($request->post("search")['value'] != null) {
            $searchValue = $request->post("search")['value'];
            $result = $model->where($whereParam,'like',$searchValue . '%')
            ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])->get();
            $totalFiltered = $result->count();

            $result = $model->where($whereParam,'like',$searchValue . '%')
            ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
            ->offset($request->post("start"))
            ->limit($request->post("length"))
            ->get();

        } else {

            if ($request->post('length') == -1) {
                $result = $model
                ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                ->get();
            } else {
                $result = $model
                ->orderBy($columns[$request->post("order")[0]['column']],$request->post("order")[0]['dir'])
                ->offset($request->post("start"))
                ->limit($request->post("length"))
                ->get();
            }
            

        }
    
        DB::disconnect();

        return array(
            'result'=>$result,
            'total'=>$total,
            'totalFiltered'=>$totalFiltered
        );
        // foreach ($result as $key => $item) {
        //     $nestedData=array(); 
        //     $addtype = "1".substr($item['item_type'],0,1)."1";
        //     $idnum = $addtype .  str_pad($item["itemno"], 6, '0', STR_PAD_LEFT);

        //     $nestedData[] = $idnum;
        //     $nestedData[] = $item["itemdesc"];
        //     $nestedData[] = $item["unit"];
        //     $itemno = $item['itemno'];
        //     $route = route('edititems',['edititemno'=>$itemno]);
        //     $nestedData[] = "<a href='$route' class='btn btn-primary btn-icon-split btn-sm'>
        //     <span class='icon text-white-50'>
        //       <i class='fas fa-edit'></i>
        //     </span>
        //     <span class='text'>Edit Item</span>
        //   </a>";
        //     $data[] = $nestedData;
        // }

        // $json_data = array(
        //             "draw"            => intval( $request->post('draw')),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        //             "recordsTotal"    => intval( $total ),  // total number of records
        //             "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        //             "data"            => $data   // total data array
        //     );
        // return json_encode($json_data);
    }

    public static function generateJson($draw,$recordsTotal,$recordsFiltered,$data)
    {
        $json_data = array(
            "draw"            => intval( $draw),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $recordsTotal ),  // total number of records
            "recordsFiltered" => intval( $recordsFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );

        return json_encode($json_data);
    }
}
