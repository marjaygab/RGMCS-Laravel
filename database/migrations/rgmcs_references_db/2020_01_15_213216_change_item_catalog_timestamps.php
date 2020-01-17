<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeItemCatalogTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('item_catalog',function (Blueprint $table)
        {
            $table->dateTime('created_at')->useCurrent();
            // $table->timestamp('update_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('item_catalog',function (Blueprint $table)
        {
            $table->dropColumn('created_at');
        });
    }
}
