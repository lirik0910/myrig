<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAutoPricesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_auto_prices', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';

			$table->increments('id');

			$table->integer('product_id', false, true)
				->default(0)
				->comment('Product ID');

			$table->float('fes_price', 12,2)
				->default('0.00')
				->comment('FES price');

			$table->integer('fes_price_currency', false, true)
				->default(0)
				->comment('FES price currency');

            $table->float('warranty_price', 12,2)
                ->default('0.00')
                ->comment('Warranty price');

            $table->integer('warranty_price_currency', false, true)
                ->default(0)
                ->comment('Warranty price currency');

			$table->float('prime_price', 12,2)
				->default('0.00')
				->comment('Prime product price');

			$table->integer('prime_price_currency', false, true)
				->default(0)
				->comment('Prime price currency');

			$table->float('profit_price', 12,2)
				->default('0.00')
				->comment('Profit product price');

			$table->integer('profit_price_currency', false, true)
				->default(0)
				->comment('Profit price currency');

			$table->float('delivery_price', 12,2)
				->default('0.00')
				->comment('Delivery product cost');

			$table->integer('delivery_price_currency', false, true)
				->default(0)
				->comment('Delivery cost currency');

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
		Schema::dropIfExists('product_auto_prices');
	}
}
