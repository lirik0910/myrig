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
			$table->increments('id');
			
			$table->integer('order_id', false, true)
				->nullable(false)
				->comment('Order ID');
			
			$table->integer('product_id', false, true)
				->nullable(false)
				->comment('Product ID');

			$table->integer('count', false, true)
				->default(1)
				->comment('Products count');

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
