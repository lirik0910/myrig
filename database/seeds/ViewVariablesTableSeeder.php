<?php

use Illuminate\Database\Seeder;

class ViewVariablesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Base\ViewVariable::create([
			'view_id' => 5,
			'variable_id' => 1,
		]);
	}
}
