<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartOverviewView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW cart_overview_view AS
        SELECT c.id,c.transaction_type,c.name,c.itemno,r.itemdesc,c.vendor,c.unit_cost,c.qtyin,c.qtyout,c.tdate,c.created_at
        FROM rgmcs_renes_cashier_db.cart AS c
        INNER JOIN rgmcs_references_db.item_list_view AS r
        ON c.itemno = r.id");
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_overview_view');
    }
}
