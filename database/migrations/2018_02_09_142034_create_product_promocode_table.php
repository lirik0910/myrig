<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPromocodeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_promocodes', function (Blueprint $table){
			$table->increments('id');
			
			$table->integer('promocode_id', false, true)
				->nullable(false)
				->comment('Promocode ID');
			
			$table->integer('product_id', false, true)
				->nullable(false)
				->comment('Product ID');

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
