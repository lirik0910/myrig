<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('views', function (Blueprint $table) {
			$table->increments('id');

			$table->string('title', 255)
				->nullable(false)
				->comment('View template name');

			$table->text('description')
				->nullable(true)
				->comment('View template description');

			$table->string('path', 255)
				->nullable(false)
				->comment('Path to view template location');

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
		Schema::dropIfExists('views');
	}
}
