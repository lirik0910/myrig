<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationOrderDiscountTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_discounts', function (Blueprint $table) {
			$table->foreign('order_id')
				->references('id')
				->on('orders')
				->onDelete('cascade');
		});

		Schema::table('order_discounts', function (Blueprint $table) {
			$table->foreign('promocode_id')
				->references('id')
				->on('promocodes')
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
