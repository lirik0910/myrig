<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationUserPolicy extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_policies', function (Blueprint $table) {
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
		
		Schema::table('user_policies', function (Blueprint $table) {
			$table->foreign('policy_id')
				->references('id')
				->on('policies')
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
