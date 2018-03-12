<?php

use Illuminate\Database\Seeder;

class MultiVariablesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Get variables
		 */
		$variable = App\Model\Base\Variable::where('title', 'Contact items')->first();

		App\Model\Base\MultiVariable::create([
			'title' => 'country',
			'description' => 'Country name',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'serviceType',
			'description' => 'Service type',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'address',
			'description' => 'Address',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'phone',
			'description' => 'Phone',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'lat',
			'description' => 'Lat',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'lng',
			'description' => 'Lng',
			'variable_id' => $variable->id
		]);
	}
}
