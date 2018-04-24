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
			'title' => 'SDEK',
			'description' => 'SDEK. Pickup. Russia',
			'color' => '#444389',
			'active' => 1
		]);

        App\Model\Shop\Delivery::create([
            'title' => 'Business lines',
            'description' => 'Business lines. Pickup. Russia',
            'color' => '#444389',
            'active' => 1
        ]);

        App\Model\Shop\Delivery::create([
            'title' => 'Self shippment',
            'description' => '',
            'color' => '#71cece',
            'active' => 1
        ]);

        App\Model\Shop\Delivery::create([
            'title' => 'Without delivery',
            'description' => '',
            'color' => '#71cece',
            'active' => 0
        ]);
	}
}
