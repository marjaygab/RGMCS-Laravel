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
        DB::statement("
        CREATE OR REPLACE VIEW all_stocks_view AS
        select `i`.`id` AS `id`,`i`.`itemdesc` AS `itemdesc`,`i`.`type` AS `type`,`i`.`unit_code` AS `unit_code`,ifnull(`w`.`qty`,0) AS `qtyw`,ifnull(`r`.`qty`,0) AS `qty2`,ifnull(`d`.`qty`,0) AS `qtyr` from (((`rgmcs_references_db`.`item_list_view` `i` left join `rgmcs_warehouse_encoder_db`.`stocks_on_hand_view` `w` on(`i`.`id` = `w`.`itemno`)) left join `rgmcs_renes_encoder_db`.`stocks_on_hand_view` `r` on(`i`.`id` = `r`.`itemno`)) left join `rgmcs_redor_encoder_db`.`stocks_on_hand_view` `d` on(`i`.`id` = `d`.`itemno`)) where `w`.`qty` > 0 or `r`.`qty` > 0 or `d`.`qty` > 0
        ");
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
