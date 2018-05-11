<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationViewVariable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('view_variables', function (Blueprint $table) {
			$table->foreign('view_id')
				->references('id')
				->on('views')
				->onDelete('cascade');
		});

		Schema::table('view_variables', function (Blueprint $table) {
			$table->foreign('variable_id')
				->references('id')
				->on('variables')
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
