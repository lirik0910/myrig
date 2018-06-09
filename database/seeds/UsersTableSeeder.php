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
		/** Get admin access policy
		 */
		$admin = App\Model\Base\Policy::where('name', 'Admin')->firstOrFail();

		/** Add admin user
		 */
		App\Model\Base\User::create([
			'policy_id' => $admin->id,
			'name' => 'admin',
			'email' => 'admin@ohmycode.studio',
			'password' => '$2y$10$ba4gmtzfXUnNC0JL95J5Aup/u/IIdULTz8kFvruLNoTQJnIM..zG2',
			'remember_token' => ''
		]);

		/** Get admin manager policy
		 */
		$manager = App\Model\Base\Policy::where('name', 'Manager')->firstOrFail();

		/** Add manager user
		 */
		App\Model\Base\User::create([
			'policy_id' => $manager->id,
			'name' => 'manager',
			'email' => 'manager@ohmycode.studio',
			'password' => '$2y$10$6uM5SSb10/D7NJUI43s4zuDOSJBC3Ymu2a9gPcnkqz1GBI1yx0Pqa',
			'remember_token' => ''
		]);
	}
}
