<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\Currency::create([
			'name' => 'USD',
			'symbol' => 'USD'
		]);

		App\Model\Shop\Currency::create([
			'name' => 'BTC',
			'symbol' => 'BTC'
		]);

		App\Model\Shop\Currency::create([
			'name' => 'PERCENT',
			'symbol' => '%'
		]);
	}
}
