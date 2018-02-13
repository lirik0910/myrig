<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationOrderDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderDelivery', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('order')
                ->onDelete('cascade');
        });

        Schema::table('orderDelivery', function (Blueprint $table) {
            $table->foreign('delivery_id')
                ->references('id')
                ->on('delivery')
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
