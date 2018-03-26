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
			'title' => 'video',
			'description' => 'Product video'
		]);

        App\Model\Shop\ProductOptionType::create([
            'title' => 'currency',
            'description' => 'Currency'
        ]);
	}
}
