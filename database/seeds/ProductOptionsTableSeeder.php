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
		$products = App\Model\Shop\Product::all();

		foreach ($products as $item) {
			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Hashrate',
				'value' => '19.3Gh ± 5%',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Energy eff',
				'value' => '80Вт/1Gh',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Energy consumption',
				'value' => '1200Вт + 10%',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Rated voltage',
				'value' => '11.6 ~ 13В',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Cooling',
				'value' => 'Fans: 6000ob / m, 4300ob / m',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'characteristic',
				'title' => 'Working conditions',
				'value' => 'от 0°C до 40°C',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'warranty',
				'title' => 'Warranty',
				'value' => 'Extended warranty 180 days',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'recoupment',
				'title' => 'Recoupment',
				'value' => 'Recoupment 193 days',
			]);

			App\Model\Shop\ProductOption::create([
				'product_id' => $item->id,
				'name' => 'status',
				'title' => 'Status',
				'value' => 'Pre-order',
			]);
		}
	}
}
