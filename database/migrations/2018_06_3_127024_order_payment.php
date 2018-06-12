<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            
            $table->increments('id');
            
            $table->integer('order_id', false, true)
                ->nullable(false)
                ->comment('Order ID');

            $table->float('cost')
                ->default('0.00')
                ->comment('Delivery cost');
            
            $table->string('first_name', 255)
                ->nullable(true)
                ->comment('Customer first name');

            $table->string('last_name', 255)
                ->nullable(true)
                ->comment('Customer last name');

            $table->string('city', 255)
                ->nullable(true)
                ->comment('Customer city');

            $table->string('country', 255)
                ->nullable(true)
                ->comment('Customer country');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

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
        //
    }
}
