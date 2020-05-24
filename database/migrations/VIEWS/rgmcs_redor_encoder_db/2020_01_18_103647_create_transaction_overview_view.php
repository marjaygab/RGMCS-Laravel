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
       select `t`.`id` AS `id`,`t`.`transaction_type` AS `transaction_type`,`t`.`name` AS `name`,`t`.`itemno` AS `itemno`,`r`.`itemdesc` AS `itemdesc`,`t`.`vendor` AS `vendor`,`t`.`unit_cost` AS `unit_cost`,`t`.`qtyin` AS `qtyin`,`t`.`qtyout` AS `qtyout`,`t`.`qtyoh` AS `qtyoh`,`t`.`tdate` AS `tdate`,`t`.`created_at` AS `created_at` from (`rgmcs_redor_encoder_db`.`transactions` `t` join `rgmcs_references_db`.`item_list_view` `r` on(`t`.`itemno` = `r`.`id`))");
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
