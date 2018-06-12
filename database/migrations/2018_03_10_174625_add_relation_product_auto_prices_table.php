<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductAutoPricesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_auto_prices', function (Blueprint $table) {
			$table->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade');

			$table->foreign('fes_price_currency')
				->references('id')
				->on('currencies')
				->onDelete('cascade');

			$table->foreign('prime_price_currency')
				->references('id')
				->on('currencies')
				->onDelete('cascade');

			$table->foreign('profit_price_currency')
				->references('id')
				->on('currencies')
				->onDelete('cascade');

			$table->foreign('delivery_price_currency')
				->references('id')
				->on('currencies')
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
