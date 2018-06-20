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
			'type' => 'input',
			'description' => 'Country name',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'serviceType',
			'type' => 'input',
			'description' => 'Service type',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'address',
			'type' => 'input',
			'description' => 'Address',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'phone',
			'type' => 'input',
			'description' => 'Phone',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'telegram',
			'type' => 'input',
			'description' => 'Telegram',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'lat',
			'type' => 'input',
			'description' => 'Lat',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'lng',
			'type' => 'input',
			'description' => 'Lng',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'lng',
			'type' => 'input',
			'description' => 'Lng',
			'variable_id' => $variable->id
		]);

		$variable = App\Model\Base\Variable::where('title', 'indexLinks')->first();
		App\Model\Base\MultiVariable::create([
			'title' => 'header',
			'type' => 'input',
			'description' => 'Header item',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'content',
			'type' => 'input',
			'description' => 'Content item',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'icon',
			'type' => 'image',
			'description' => 'Item icon',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'link',
			'type' => 'input',
			'description' => 'Link',
			'variable_id' => $variable->id
		]);

		$variable = App\Model\Base\Variable::where('title', 'indexSlider')->first();
		App\Model\Base\MultiVariable::create([
			'title' => 'slideHeader',
			'type' => 'input',
			'description' => 'Slide header',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'slideContent',
			'type' => 'richtext',
			'description' => 'Slide content',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'slideLink',
			'type' => 'input',
			'description' => 'Link',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'sliderIcon',
			'type' => 'image',
			'description' => 'Slide image',
			'variable_id' => $variable->id
		]);

		$variable = App\Model\Base\Variable::where('title', 'calculatorDevices')->first();
		App\Model\Base\MultiVariable::create([
			'title' => 'name',
			'type' => 'input',
			'description' => 'Device name',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'hashreit',
			'type' => 'input',
			'description' => 'Hashreit value',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'consumption',
			'type' => 'input',
			'description' => 'Energy consumption value',
			'variable_id' => $variable->id
		]);

		App\Model\Base\MultiVariable::create([
			'title' => 'currency',
			'type' => 'input',
			'description' => 'Currency',
			'variable_id' => $variable->id
		]);

        App\Model\Base\MultiVariable::create([
            'title' => 'hosting',
            'type' => 'input',
            'description' => 'Hosting',
            'variable_id' => $variable->id
        ]);
	}
}
