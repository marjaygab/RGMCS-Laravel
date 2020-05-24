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
        select `s`.`id` AS `id`,`s`.`itemno` AS `itemno`,`r`.`itemdesc` AS `itemdesc`,`r`.`unit_code` AS `unit_code`,`r`.`type` AS `type`,`s`.`qty` AS `qty` from (`rgmcs_renes_encoder_db`.`stocks` `s` join `rgmcs_references_db`.`item_list_view` `r` on(`s`.`itemno` = `r`.`id`))");
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
