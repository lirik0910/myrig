<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationOrderDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderDiscount', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('order')
                ->onDelete('cascade');
        });

        Schema::table('orderDiscount', function (Blueprint $table) {
            $table->foreign('promocode_id')
                ->references('id')
                ->on('promocode')
                ->onDelete('cascade');
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
    }
}
