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
		$view = App\Model\Base\View::where('title', 'Product')->first();
		$variable = App\Model\Base\Variable::where('title', 'Product information items')->first();

		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $variable->id,
		]);

		$view = App\Model\Base\View::where('title', 'Contacts')->first();
		$variable = App\Model\Base\Variable::where('title', 'Contact items')->first();

		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $variable->id,
		]);

		$view = App\Model\Base\View::where('title', 'Index')->first();
		$variable = App\Model\Base\Variable::where('title', 'indexLinks')->first();

		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $variable->id,
		]);

		$variable = App\Model\Base\Variable::where('title', 'indexSlider')->first();
		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $variable->id,
		]);

		$view = App\Model\Base\View::where('title', 'Calculator')->first();
		$variable = App\Model\Base\Variable::where('title', 'calculatorDevices')->first();
		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $variable->id,
		]);
	}
}
