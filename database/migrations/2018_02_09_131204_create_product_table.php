<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table){
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
			
			$table->increments('id');

			$table->integer('context_id', false, true)
				->default(0)
				->comment('Context ID');

			/*$table->integer('category_id', false, true)
				->default(1)
				->comment('Product category ID');*/

			$table->integer('vendor_id', false, true)
				->default(1)
				->comment('Vendor ID');

			$table->integer('page_id', false, true)
				->default(0)
				->comment('Page ID');

			$table->integer('product_status_id', false, true)
				->default(0)
				->comment('Product status ID');
			
			$table->string('title', 255)
				->nullable(false)
				->comment('Product name');

			$table->string('articul', 255)
				->nullable(false)
				->comment('Product articul');

			$table->text('description')
				->nullable(true)
				->comment('Product description');

			$table->string('warranty', 255)
				->nullable(true)
				->comment('Product warranty');

			$table->tinyInteger('active')
				->default(1)
				->comment('Product active status');

			$table->tinyInteger('auto_price')
				->default(0)
				->comment('Auto price regime');

			$table->float('price', 12,2)
				->default('0.00')
				->comment('Product price');

			$table->float('compare_price', 12,2)
				->default('0.00')
				->comment('Compare price');

			$table->tinyInteger('delete')
				->default(0)
				->comment('If product in trash');

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
