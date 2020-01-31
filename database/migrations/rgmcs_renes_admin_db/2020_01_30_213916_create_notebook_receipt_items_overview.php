<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotebookReceiptItemsOverview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW notebook_receipt_items_overview AS SELECT r.id,r.vendor,r.tdate,i.itemno,i.itemdesc,i.baseprice,i.d1,i.d2,i.d3,i.d4,i.netprice,r.total,r.created_at AS created_receipt_at,i.created_at AS created_receipt_item_at FROM notebook_receipt AS r
        INNER JOIN notebook_receipt_items AS i
        ON i.receipt_id = r.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notebook_receipt_items_overview');
    }
}
