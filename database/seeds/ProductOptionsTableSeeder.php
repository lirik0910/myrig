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
		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Hesreit',
			'value' => '19.3Gh ± 5%',
		]);

		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Energy Efficiency',
			'value' => '80Вт/1Gh',
		]);

		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Energy consumption',
			'value' => '1200Вт + 10%',
		]);

		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Rated voltage',
			'value' => '11.6 ~ 13В',
		]);

		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Cooling',
			'value' => 'Fans: 6000ob / m, 4300ob / m',
		]);

		App\Model\Base\ProductOption::create([
			'product_id' => 2,
			'name' => 'Working conditions',
			'value' => 'от 0°C до 40°C',
		]);
	}
}
