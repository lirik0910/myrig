<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->foreign('status_id')
                ->references('id')
                ->on('orderStatus')
                ->onDelete('cascade');
        });

        Schema::table('order', function (Blueprint $table) {
            $table->foreign('paymentType_id')
                ->references('id')
                ->on('paymentType')
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
