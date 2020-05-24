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
        select `c`.`id` AS `id`,`c`.`transaction_type` AS `transaction_type`,`c`.`name` AS `name`,`c`.`itemno` AS `itemno`,`r`.`itemdesc` AS `itemdesc`,`c`.`vendor` AS `vendor`,`c`.`unit_cost` AS `unit_cost`,`c`.`qtyin` AS `qtyin`,`c`.`qtyout` AS `qtyout`,`c`.`tdate` AS `tdate`,`c`.`created_at` AS `created_at` from (`rgmcs_redor_encoder_db`.`cart` `c` join `rgmcs_references_db`.`item_list_view` `r` on(`c`.`itemno` = `r`.`id`))");
       
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
