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
			'title' => 'Новая почта',
			'description' => 'Новая почта. Доставка. Украина',
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
            'title' => 'Самовывоз',
            'description' => '',
            'color' => '#71cece',
            'active' => 1
        ]);
	}
}
