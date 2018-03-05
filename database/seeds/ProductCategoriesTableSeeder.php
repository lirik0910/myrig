<?php

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add base product category
		 */
		App\Model\Shop\ProductCategory::create([
			'title' => 'Base',
			'description' => 'Base category',
			'active' => 1
		]);
	}
}
