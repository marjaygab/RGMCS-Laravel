<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateItemOverviewView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW item_overview_view AS SELECT l.id,l.itemdesc,l.unit_code,l.type,s.qty AS qty
        FROM rgmcs_references_db.item_list_view as l
        INNER JOIN rgmcs_renes_cashier_db.stocks AS s
        ON s.itemno = l.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_overview_view');
    }
}
