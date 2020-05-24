<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('transaction_type',99);
            $table->string('name',99);
            $table->integer('itemno');
            $table->string('vendor',99);
            $table->decimal('unit_cost',10,2);
            $table->integer('qtyin');
            $table->integer('qtyout');
            $table->integer('qtyoh');
            $table->date('tdate');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
