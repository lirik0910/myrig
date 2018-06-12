<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationMultiVariablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('multi_variables', function (Blueprint $table) {
			$table->foreign('variable_id')
				->references('id')
				->on('variables')
				->onDelete('cascade');
		});

		Schema::table('multi_variable_lines', function (Blueprint $table) {
			$table->foreign('variable_id')
				->references('id')
				->on('variables')
				->onDelete('cascade');

			$table->foreign('page_id')
				->references('id')
				->on('pages')
				->onDelete('cascade');
		});

		Schema::table('multi_variable_contents', function (Blueprint $table) {
			$table->foreign('multi_variable_id')
				->references('id')
				->on('multi_variables')
				->onDelete('cascade');

			$table->foreign('multi_variable_line_id')
				->references('id')
				->on('multi_variable_lines')
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
