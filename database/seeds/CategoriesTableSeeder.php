<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
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
		App\Model\Shop\Category::create([
			'title' => 'Base',
			'description' => 'Base category',
			'active' => 1
		]);

		App\Model\Shop\Category::create([
			'title' => 'Secondary',
			'description' => 'Secondary products category',
			'active' => 1
		]);

        App\Model\Shop\Category::create([
            'title' => 'Services',
            'description' => 'Services category',
            'active' => 1
        ]);

        App\Model\Shop\Category::create([
            'title' => 'Hosting',
            'description' => 'Hosting payment category',
            'active' => 1
        ]);
	}
}
