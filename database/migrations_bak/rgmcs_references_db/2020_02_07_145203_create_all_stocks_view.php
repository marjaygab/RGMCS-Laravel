<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAllStocksView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW all_stocks_view AS
        SELECT i.id,i.itemdesc,i.type,i.unit_code,IFNULL(w.qty,0) AS qtyw,IFNULL(r.qty,0) AS qty2,IFNULL(d.qty,0) AS qtyr
        FROM rgmcs_references_db.item_list_view AS i
        LEFT OUTER JOIN rgmcs_warehouse_encoder_db.stocks_on_hand_view AS w 
        ON i.id = w.itemno
        LEFT OUTER JOIN rgmcs_renes_encoder_db.stocks_on_hand_view AS r 
        ON i.id = r.itemno
        LEFT OUTER JOIN rgmcs_redor_encoder_db.stocks_on_hand_view AS d 
        ON i.id = d.itemno
        WHERE w.qty > 0 OR r.qty > 0 OR d.qty > 0");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_stocks_view');
    }
}
