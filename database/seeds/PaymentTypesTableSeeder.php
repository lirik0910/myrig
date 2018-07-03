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
		    'id' => 1,
			'title' => 'Bitcoin',
			'description' => 'Payment by bitcoin',
			'active' => 1
		]);

		App\Model\Shop\PaymentType::create([
		    'id' => 2,
			'title' => 'Cash',
			'description' => 'Cash payment',
			'active' => 1
		]);

        App\Model\Shop\PaymentType::create([
            'id' => 3,
            'title' => 'Cashless',
            'description' => 'Безналичный расчет',
            'active' => 1
        ]);
	}
}
