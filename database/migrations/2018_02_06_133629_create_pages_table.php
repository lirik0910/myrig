<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('parent_id', false, true)
				->default(0)
				->comment('ID of parent page');

			$table->integer('context_id', false, true)
				->default(0)
				->comment('Context of current page');

			$table->integer('view_id', false, true)
				->default(0)
				->comment('View template of current page');

			$table->string('link', 255)
				->nullable(false)
				->comment('View template of current page');

			$table->string('title', 255)
				->nullable(false)
				->comment('Title page');

			$table->string('description', 255)
				->nullable(false)
				->comment('Description page');

			$table->text('introtext')
				->nullable(true)
				->comment('Description page');

			$table->text('content')
				->nullable(true)
				->comment('Page content');

			$table->integer('createdby_id', false, true)
				->default(0)
				->comment('User ID who created current page');

			$table->integer('updatedby_id', false, true)
				->default(0)
				->comment('User ID who updated current page last');

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
		Schema::dropIfExists('pages');
	}
}
