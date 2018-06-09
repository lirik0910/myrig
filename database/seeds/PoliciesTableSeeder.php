<?php

use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Access policy for admin
		 */
		App\Model\Base\Policy::create([
			'name' => 'Admin',
			'description' => 'Access policy for admin',
		]);

		/** Access policy for manager
		 */
		App\Model\Base\Policy::create([
			'name' => 'Manager',
			'description' => 'Access policy for manager',
		]);

		/** Access policy for simple member
		 */
		App\Model\Base\Policy::create([
			'name' => 'Member',
			'description' => 'Access policy for simple member',
		]);
	}
}
