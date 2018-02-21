<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTypeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_types', function (Blueprint $table){
			$table->increments('id');

			$table->string('title', 255)
				->nullable(false)
				->comment('Payment type name');

			$table->text('description')
				->nullable(true)
				->comment('Payment type description');

			$table->tinyInteger('active')
				->default(1)
				->comment('Payment type active status');

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
