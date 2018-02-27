<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatus extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_statuses', function (Blueprint $table){
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';
			
			$table->increments('id');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Status name');
			
			$table->text('description')
				->nullable(true)
				->comment('Status description');

			$table->string('color', 255)
				->default('#000')
				->comment('Status color');

			$table->tinyInteger('active')
				->default(1)
				->comment('Status active status');

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
