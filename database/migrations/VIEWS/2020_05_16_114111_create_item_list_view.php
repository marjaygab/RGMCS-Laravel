<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW item_list_view AS select `i`.`id` AS `id`,`i`.`itemdesc` AS `itemdesc`,`t`.`type` AS `type`,`u`.`unit_code` AS `unit_code` from ((`rgmcs_references_db`.`item_catalog` `i` join `rgmcs_references_db`.`units` `u` on(`i`.`unit_id` = `u`.`id`)) join `rgmcs_references_db`.`item_types` `t` on(`i`.`item_type_id` = `t`.`id`))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_list_view');
    }
}
