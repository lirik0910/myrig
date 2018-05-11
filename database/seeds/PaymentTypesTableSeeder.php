<?php

use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\PaymentType::create([
			'title' => 'Bitcoin',
			'description' => 'Payment by bitcoin',
			'active' => 1
		]);

		App\Model\Shop\PaymentType::create([
			'title' => 'Cash',
			'description' => 'Cash payment',
			'active' => 1
		]);
	}
}
