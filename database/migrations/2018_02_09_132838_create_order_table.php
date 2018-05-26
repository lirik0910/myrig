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
		Schema::create('orders', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');
			
			$table->integer('number', false, true)
				->nullable(false)
				->comment('Order number');
			
			$table->integer('user_id', false, true)
				->nullable(false)
				->comment('Customer user ID');

			$table->float('cost')
				->default('0.00')
				->comment('Order cost');

			$table->float('prepayment')
				->defaut('0.00')
				->comment('Order prepayment');

			$table->integer('status_id', false, true)
				->nullable(false)
				->comment('Order status ID');

			$table->tinyInteger('paid')
				->default(0)
				->comment('Order paid status');

			$table->integer('payment_type_id', false, true)
				->nullable(false)
				->comment('Payment type of order');
			
			$table->integer('context_id', false, true)
				->nullable(false)
				->comment('Order context ID');

			$table->tinyInteger('delete')
				->default(0)
				->comment('If order in trash');

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
