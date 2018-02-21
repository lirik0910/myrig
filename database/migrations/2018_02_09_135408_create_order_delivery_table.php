<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDeliveryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_deliveries', function (Blueprint $table){
			$table->increments('id');
			
			$table->integer('order_id', false, true)
				->nullable(false)
				->comment('Order ID');
			
			$table->integer('delivery_id', false, true)
				->nullable(false)
				->comment('Delivery ID');

			$table->float('cost')
				->default('0.00')
				->comment('Delivery cost');

			$table->string('first_name', 255)
				->nullable(true)
				->comment('Customer first name');

			$table->string('last_name', 255)
				->nullable(true)
				->comment('Customer last name');

			$table->string('phone', 255)
				->nullable(true)
				->comment('Customer phone');

			$table->string('email', 255)
				->nullable(true)
				->comment('Customer email');

			$table->string('city', 255)
				->nullable(true)
				->comment('Customer city');

			$table->string('country', 255)
				->nullable(true)
				->comment('Customer country');

			$table->string('address', 255)
				->nullable(true)
				->comment('Customer address');

			$table->string('comment', 255)
				->nullable(true)
				->comment('Customer comment');

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
