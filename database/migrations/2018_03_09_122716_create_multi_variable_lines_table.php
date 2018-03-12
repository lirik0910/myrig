<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultiVariableLinesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('multi_variable_lines', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('variable_id', false, true)
				->default(0)
				->comment('Variable ID');

			$table->integer('page_id', false, true)
				->default(0)
				->comment('Page ID');

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
		Schema::dropIfExists('multi_variable_lines');
	}
}
