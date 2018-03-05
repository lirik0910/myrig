<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationPolicyAction extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('policy_actions', function (Blueprint $table) {
			$table->foreign('policy_id')
				->references('id')
				->on('policies')
				->onDelete('cascade');
		});

		Schema::table('policy_actions', function (Blueprint $table) {
			$table->foreign('action_id')
				->references('id')
				->on('actions')
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
