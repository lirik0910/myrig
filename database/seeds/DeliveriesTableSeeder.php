<?php

use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\Delivery::create([
			'title' => 'Nova Pochta. Pickup',
			'description' => 'Nova Pochta. Pickup. Ukraine',
			'color' => '#D82020',
			'active' => 1
		]);

		App\Model\Shop\Delivery::create([
			'title' => 'SDEK. Business lines',
			'description' => 'SDEK. Business lines Pickup. Russia',
			'color' => '#444389',
			'active' => 1
		]);
	}
}