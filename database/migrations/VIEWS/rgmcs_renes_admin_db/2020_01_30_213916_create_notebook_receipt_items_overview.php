<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotebookReceiptItemsOverview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "
            CREATE OR REPLACE VIEW notebook_receipt_items_overview AS 
            SELECT
            `r`.`id` AS `receipt_no`,
            `i`.`id` AS `receipt_item_no`,
            `r`.`vendor` AS `vendor`,
            `r`.`tdate` AS `tdate`,
            `i`.`itemno` AS `itemno`,
            `i`.`itemdesc` AS `itemdesc`,
            `i`.`baseprice` AS `baseprice`,
            `i`.`d1` AS `d1`,
            `i`.`d2` AS `d2`,
            `i`.`d3` AS `d3`,
            `i`.`d4` AS `d4`,
            `i`.`netprice` AS `netprice`,
            `i`.`created_at` AS `created_at`
            FROM
                (
                    `rgmcs_renes_admin_db`.`notebook_receipt` `r`
                JOIN `rgmcs_renes_admin_db`.`notebook_receipt_items` `i`
                ON
                    (`i`.`receipt_id` = `r`.`id`)
                )
            "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notebook_receipt_items_overview');
    }
}
