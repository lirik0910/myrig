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

        /** Add products inforamation text
         */
        App\Model\Base\Variable::create([
            'type' => 'multi',
            'title' => 'Contact items',
            'description' => 'Item for contacts page',
        ]);

        /** Add products inforamation text
         */
        App\Model\Base\Variable::create([
            'type' => 'multi',
            'title' => 'footerPhoneItem',
            'description' => 'Contacts phone item at footer',
        ]);
	}
}
