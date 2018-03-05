<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionTable extends Migration
{
<<<<<<< HEAD
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('name', 255);
            $table->text('value');
            $table->timestamps();
        });
    }
=======
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_options', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci';
>>>>>>> 7d1c887b0cc4a0fd99475e033d90d28f7304e8b4

			$table->increments('id');

			$table->integer('product_id', false, true)
				->nullable(false)
				->comment('Product ID');

			$table->string('name', 255)
				->nullable(false)
				->comment('Option name');

			$table->string('value', 255)
				->nullable(true)
				->comment('Option value');
			
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
		Schema::dropIfExists('product_option');
	}
}
