<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deliveries', function (Blueprint $table){
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Delivery name');

			$table->text('description')
				->nullable(true)
				->comment('Delivery description');

			$table->string('color', 255)
				->default('#000')
				->comment('Delivery color');

			$table->tinyInteger('active')
				->dafault(1)
				->comment('Delivery active status');

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
