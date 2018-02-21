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
		Schema::table('order_deliveries', function (Blueprint $table) {
			$table->foreign('order_id')
				->references('id')
				->on('orders')
				->onDelete('cascade');
		});

		Schema::table('order_deliveries', function (Blueprint $table) {
			$table->foreign('delivery_id')
				->references('id')
				->on('deliveries')
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
