<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultiVariableContentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('multi_variable_contents', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';

			$table->increments('id');

			$table->integer('multi_variable_id', false, true)
				->default(0)
				->comment('Multi variable field ID');

			$table->integer('multi_variable_line_id', false, true)
				->default(0)
				->comment('Multi variable line ID');
				
			$table->text('content')
				->nullable(true)
				->comment('Variable content');

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
		Schema::dropIfExists('multi_variable_contents');
	}
}
