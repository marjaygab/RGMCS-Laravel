<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactionOverviewView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement("CREATE OR REPLACE VIEW transactions_overview_view AS
       SELECT t.id,t.transaction_type,t.name,t.itemno,r.itemdesc,t.vendor,t.unit_cost,t.qtyin,t.qtyout,t.qtyoh,t.tdate,t.created_at
       FROM rgmcs_renes_cashier_db.transactions AS t   
       INNER JOIN rgmcs_references_db.item_list_view AS r
       ON t.itemno = r.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_overview_view');
    }
}
