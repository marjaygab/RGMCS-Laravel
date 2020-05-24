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
        DB::statement("CREATE OR REPLACE VIEW item_overview_view AS select `l`.`id` AS `id`,`l`.`itemdesc` AS `itemdesc`,`l`.`unit_code` AS `unit_code`,`l`.`type` AS `type`,`s`.`qty` AS `qty` from (`rgmcs_references_db`.`item_list_view` `l` join `rgmcs_redor_encoder_db`.`stocks` `s` on(`s`.`itemno` = `l`.`id`))");
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
