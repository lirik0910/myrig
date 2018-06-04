<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_categories', function (Blueprint $table) {
			$table->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade');
		});

		Schema::table('product_categories', function (Blueprint $table) {
			$table->foreign('category_id')
				->references('id')
				->on('categories')
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
