<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Receipt;
use App\ReceiptItems;
use Illuminate\Support\Facades\Validator;

class SingleNotebookItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($itemNo)
    {
        // Get Receipts linked to this receipt item
        $receiptsItems = ReceiptItems::where('itemno', $itemNo)
        ->with(['receipts'=>function($query){
            $query->select('*');
        }])
        ->get();

        return view('singlenotebookitem', compact('receiptsItems', 'itemNo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get Validated Details
        $details = $request->all();

        // Update Details
        $item = ReceiptItems::find($id);
        $item->baseprice = $details['basePrice'];
        $item->d1 = $details['d1'];
        $item->d2 = $details['d2'];
        $item->d3 = $details['d3'];
        $item->d4 = $details['d4'];
        $item->save();

        return redirect('/notebook/item/' . $details['itemNo']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Get Validated Details
        $details = $request->all();

        // Delete Item
        ReceiptItems::where('id', $id)->delete();

        return redirect('/notebook/item/' . $details['itemNo']);
    }
}
