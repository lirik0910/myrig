<?php

use Illuminate\Database\Seeder;

class VariablesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add products inforamation text
		 */
		App\Model\Base\Variable::create([
			'type' => 'input',
			'title' => 'Product information items',
			'description' => '',
		]);
	}
}
