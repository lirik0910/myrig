<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductCollections extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_collections', function (Blueprint $table) {
			$table->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade');
		});

		Schema::table('product_collections', function (Blueprint $table) {
			$table->foreign('collection_id')
				->references('id')
				->on('collections')
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
