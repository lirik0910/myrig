<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promocodes', function (Blueprint $table){
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Promocode name');
			
			$table->text('description')
				->nullable(true)
				->comment('Promocode description');
			
			$table->integer('count', false, true)
				->default(1)
				->comment('Number of promocode used');
			
			$table->float('value')
				->dafult('1.00')
				->comment('Fixed promocode discount');
			
			$table->integer('percent', false, true)
				->dafult(1)
				->comment('Percent promocode discount');;
			
			$table->tinyInteger('active')
				->default(1)
				->comment('Promocode active status');

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
