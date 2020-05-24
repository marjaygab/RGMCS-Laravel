<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStocksOnHandView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW stocks_on_hand_view AS select `rgmcs_redor_encoder_db`.`stocks`.`id` AS `id`,`rgmcs_redor_encoder_db`.`stocks`.`itemno` AS `itemno`,`rgmcs_redor_encoder_db`.`stocks`.`qty` AS `qty`,`rgmcs_redor_encoder_db`.`stocks`.`updated_at` AS `updated_at` from `rgmcs_redor_encoder_db`.`stocks` where `rgmcs_redor_encoder_db`.`stocks`.`qty` > 0");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks_on_hand_view');
    }
}
