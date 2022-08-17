<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    //
    protected $table = "notebook_receipt";
    public $timestamps = true;

    public function items() {
        return $this->hasMany(ReceiptItems::class, 'receipt_id');
    }
}
