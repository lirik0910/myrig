<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table){
			$table->increments('id');

			$table->integer('category_id', false, true)
				->default(0)
				->comment('Product category ID');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Product name');

			$table->text('description')
				->nullable(true)
				->comment('Product description');

			$table->string('icon', 255)
				->nullable(true)
				->comment('Product preview image');

			$table->tinyInteger('active')
				->default(1)
				->comment('Product active status');

			$table->float('price')
				->default('0.00')
				->comment('Product price');

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
