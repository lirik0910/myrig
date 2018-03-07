<?php

use Illuminate\Database\Seeder;

class ProductOptionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
			'title' => 'Hashrate',
			'value' => '19.3Gh ± 5%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
			'title' => 'Energy eff',
			'value' => '80Вт/1Gh',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
            'title' => 'Energy consumption',
			'value' => '1200Вт + 10%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
            'title' => 'Rated voltage',
			'value' => '11.6 ~ 13В',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
            'title' => 'Cooling',
			'value' => 'Fans: 6000ob / m, 4300ob / m',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => 2,
			'name' => 'charact',
            'title' => 'Working conditions',
			'value' => 'от 0°C до 40°C',
		]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Hashrate',
            'value' => '18.3Gh ± 5%',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Energy eff',
            'value' => '90Вт/1Gh',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Energy consumption',
            'value' => '1300Вт + 10%',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Rated voltage',
            'value' => '13.6 ~ 13В',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Cooling',
            'value' => 'Fans: 6000ob / m, 4300ob / m',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'charact',
            'title' => 'Working conditions',
            'value' => 'от 0°C до 35°C',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'warranty',
            'title' => '',
            'value' => 'Extended warranty 180 days',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 2,
            'name' => 'warranty',
            'title' => '',
            'value' => 'Extended warranty 180 days',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'recoupment',
            'title' => '',
            'value' => 'Recoupment 219 days',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 2,
            'name' => 'recoupment',
            'title' => '',
            'value' => 'Recoupment 193 days',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 1,
            'name' => 'status',
            'title' => '',
            'value' => 'Pre-order',
        ]);

        App\Model\Shop\ProductOption::create([
            'product_id' => 2,
            'name' => 'status',
            'title' => '',
            'value' => 'Pre-order',
        ]);
	}
}
