<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_catalog', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('itemdesc',99);
            $table->string('unit',10);
            $table->string('item_type',64);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_catalog');
    }
}
