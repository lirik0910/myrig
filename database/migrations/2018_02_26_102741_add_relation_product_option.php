<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductOption extends Migration
{
<<<<<<< HEAD
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_options', function (Blueprint $table){
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
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
		Schema::table('product_options', function (Blueprint $table){
			$table->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade');
		});
	}
>>>>>>> 7d1c887b0cc4a0fd99475e033d90d28f7304e8b4

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
