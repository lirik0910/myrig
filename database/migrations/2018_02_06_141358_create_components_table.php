<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('components', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name', 255)
				->nullable(false)
				->comment('Component name');

			$table->text('description')
				->nullable(true)
				->comment('Component description');

			$table->string('link', 255)
				->nullable(true)
				->comment('Component link in manager');

			$table->string('icon', 255)
				->nullable(true)
				->comment('Component icon');

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
		Schema::dropIfExists('components');
	}
}
