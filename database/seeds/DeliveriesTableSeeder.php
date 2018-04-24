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
			'title' => 'СДЕК',
			'description' => 'СДЕК. Доставка. Россия',
			'color' => '#444389',
			'active' => 1
		]);

        App\Model\Shop\Delivery::create([
            'title' => 'Деловые линии',
            'description' => 'Деловые линии. Доставка. Россия',
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
