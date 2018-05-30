<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_logs', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';

			$table->increments('id');

			$table->integer('order_id', false, true)
				->default(0)
				->comment('Order ID');

			$table->integer('user_id', false, true)
				->default(0)
				->comment('User ID who changed order');

			$table->text('type')
				->default('status')
				->comment('Log type (status|paid|cost|delivery|payment|note)');

			$table->string('value')
				->default('')
				->comment('Log value');

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
		Schema::dropIfExists('order_logs');
	}
}
