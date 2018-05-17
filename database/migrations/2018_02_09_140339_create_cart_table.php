<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function (Blueprint $table){
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');
			
			$table->integer('order_id', false, true)
				->nullable(false)
				->comment('Order ID');
			
			$table->integer('product_id', false, true)
				->nullable(false)
				->comment('Product ID');

            $table->float('cost', 2, false, true)
                ->default(0.00)
                ->comment('Products cost');

            $table->float('btcCost', 4, false, true)
                ->default(0.0000)
                ->comment('Products cost in bitcoin');

			$table->integer('count', false, true)
				->default(1)
				->comment('Products count');

			$table->float('fes', 2, false, true)
				->nullable(true)
				->comment('FES constant');

			$table->float('warranty', false, true)
				->nullable(true)
				->comment('Warranty of product');

			$table->float('prime_cost', false, true)
				->nullable(true)
				->comment('Prime cost of product');

			$table->float('delivery_cost', false, true)
			   ->nullable(true)
			   ->comment('Delivery cost of product');

			$table->float('profit', false, true)
				->nullable(true)
				->comment('Profit of product');

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
