<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_categories', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');
			
			$table->integer('parent_id', false, true)
				->default(0)
				->comment('Parent category ID');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Category name');
			
			$table->text('description')
				->nullable(true)
				->comment('Category description');
			
			$table->tinyInteger('active')
				->default(1)
				->comment('Category active status');

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
