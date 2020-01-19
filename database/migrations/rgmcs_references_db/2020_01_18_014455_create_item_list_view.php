<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("CREATE VIEW item_list_view AS SELECT i.id,i.itemdesc,t.type,u.unit_code FROM item_catalog AS i INNER JOIN units as u ON i.unit_id = u.id INNER JOIN item_types as t ON i.item_type_id = t.id");
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
