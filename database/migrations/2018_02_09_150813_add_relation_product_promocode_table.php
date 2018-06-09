<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductPromocodeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_promocodes', function (Blueprint $table) {
			$table->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade');
		});

		Schema::table('product_promocodes', function (Blueprint $table) {
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
