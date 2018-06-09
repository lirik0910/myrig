<?php

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add base vendor
		 */
		App\Model\Shop\Vendor::create([
			'title' => 'Base',
			'description' => 'Base vendor',
		]);
	}
}
