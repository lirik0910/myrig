<?php

use Illuminate\Database\Seeder;

class ProductOptionTypesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\ProductOptionType::create([
			'title' => 'characteristic',
			'description' => 'Product characteristic item'
		]);

		App\Model\Shop\ProductOptionType::create([
			'title' => 'warranty',
			'description' => 'Product warranty'
		]);

		App\Model\Shop\ProductOptionType::create([
			'title' => 'recoupment',
			'description' => 'Product recoupment'
		]);

		App\Model\Shop\ProductOptionType::create([
			'title' => 'status',
			'description' => 'Product status item'
		]);

		App\Model\Shop\ProductOptionType::create([
			'title' => 'video',
			'description' => 'Product video'
		]);

		App\Model\Shop\ProductOptionType::create([
			'title' => 'secondary',
			'description' => 'If product is secondary'
		]);
	}
}
