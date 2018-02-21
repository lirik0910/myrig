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
		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('status_id')
				->references('id')
				->on('order_statuses')
				->onDelete('cascade');
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('payment_type_id')
				->references('id')
				->on('payment_types')
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
