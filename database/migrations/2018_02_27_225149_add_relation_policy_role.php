<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationPolicyRole extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('policy_roles', function (Blueprint $table) {
			$table->foreign('policy_id')
				->references('id')
				->on('policies')
				->onDelete('cascade');
		});

		Schema::table('policy_roles', function (Blueprint $table) {
			$table->foreign('role_id')
				->references('id')
				->on('roles')
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
