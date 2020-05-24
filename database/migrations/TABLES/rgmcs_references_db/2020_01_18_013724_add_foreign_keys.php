<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_catalog',function (Blueprint $table)
        {
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('item_type_id')->references('id')->on('item_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_catalog',function (Blueprint $table)
        {
            $table->dropForeign('unit_id');
            $table->dropForeign('item_type_id');
        });
    }
}
