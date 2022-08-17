<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptItems extends Model
{
    //
    protected $table = "notebook_receipt_items";
    public $timestamps = true;

    public function receipts(){
	    return $this->belongsTo(Receipt::class, 'receipt_id', 'id');
	}
}
