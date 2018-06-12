<?php

use Illuminate\Database\Seeder;

class ProductStatusesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\ProductStatus::create([
			'title' => 'pre-order',
			'description' => 'Pre-order'
		]);

		App\Model\Shop\ProductStatus::create([
			'title' => 'in-stock',
			'description' => 'In stock'
		]);

		App\Model\Shop\ProductStatus::create([
			'title' => 'not-available',
			'description' => 'Not available'
		]);
	}
}
