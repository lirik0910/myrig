<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDiscountTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_discounts', function (Blueprint $table){
			$table->increments('id');
			
			$table->integer('order_id', false, true)
				->nullable(false)
				->comment('Order ID');
			
			$table->integer('promocode_id', false, true)
				->nullable(false)
				->comment('Promocode ID');
			
			$table->float('sum')
				->default('0.00')
				->comment('Order discount sum');

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
