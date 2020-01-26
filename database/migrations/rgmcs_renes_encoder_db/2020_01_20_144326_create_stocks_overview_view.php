<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStocksOverviewView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW stocks_overview_view AS
        SELECT s.id,r.itemdesc,r.unit_code,r.type,s.qty
        FROM rgmcs_renes_encoder_db.stocks AS s   
        INNER JOIN rgmcs_references_db.item_list_view AS r
        ON s.itemno = r.id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks_overview_view');
    }
}
