<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCartsCollumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
        	$table->float('fes', 12,2, false, true)
                ->nullable(true)
                ->comment('FES constant');

            $table->float('warranty', 12,2, false, true)
                ->nullable(true)
                ->comment('Warranty of product');

            $table->float('prime_cost', 12,2, false, true)
                ->nullable(true)
                ->comment('Prime cost of product');

            $table->float('delivery_cost', 12,2, false, true)
                ->nullable(true)
                ->comment('Delivery cost of product');

            $table->float('discount', 12,2, false, true)
                ->nullable(true)
                ->comment('Delivery cost of product');

            $table->float('profit', 12,2, false, true)
                ->nullable(true)
                ->comment('Profit of product');

            $table->string('serial_number', 255)
                ->nullable(true)
                ->comment('serial_number of product');

            $table->string('title', 255)
                ->nullable(true)
                ->comment('Cart item`s title');
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
