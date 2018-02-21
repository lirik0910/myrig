<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add admin user
		 */
		App\User::create([
			'name' => 'admin',
			'email' => 'admin@ohmycode.studio',
			'password' => '$2y$10$ba4gmtzfXUnNC0JL95J5Aup/u/IIdULTz8kFvruLNoTQJnIM..zG2',
			'remember_token' => ''
		]);

		/** Add manager user
		 */
		App\User::create([
			'name' => 'manager',
			'email' => 'manager@ohmycode.studio',
			'password' => '$2y$10$6uM5SSb10/D7NJUI43s4zuDOSJBC3Ymu2a9gPcnkqz1GBI1yx0Pqa',
			'remember_token' => ''
		]);
	}
}
