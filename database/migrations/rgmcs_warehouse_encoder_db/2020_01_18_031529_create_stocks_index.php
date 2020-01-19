<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks',function (Blueprint $table)
        {
           $table->index('itemno','ItemNoIndex'); 
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks',function (Blueprint $table)
        {
            $table->dropIndex('ItemNoIndex');
        });
    }
}
