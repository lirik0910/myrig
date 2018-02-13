<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table){
            $table->increments('id');
            $table->integer('number')
                ->unsigned();;
            $table->integer('user_id')
                ->unsigned();
            $table->float('cost');
            $table->float('prepayment');
            $table->integer('status_id')
                ->unsigned();
            $table->tinyInteger('paid');
            $table->integer('paymentType_id')
                ->unsigned();
            $table->integer('context')
                ->unsigned();
            $table->timestamp('createdtime');
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
