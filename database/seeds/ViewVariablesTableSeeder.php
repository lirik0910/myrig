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
		$view = App\Model\Base\View::where('title', 'Product')->firstOrFail();
		$var = App\Model\Base\Variable::where('title', 'Product information items')->firstOrFail();

		App\Model\Base\ViewVariable::create([
			'view_id' => $view->id,
			'variable_id' => $var->id,
		]);
	}
}
