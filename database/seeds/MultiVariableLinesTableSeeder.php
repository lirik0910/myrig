<?php

use Illuminate\Database\Seeder;

class MultiVariableLinesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Get page
		 */
		$contact = App\Model\Base\Page::whereHas('view', function ($q) {
			$q->where('title', 'Contacts');
		})->first();

		/** Get variables
		 */
		$variable = App\Model\Base\Variable::where('title', 'Contact items')->first();

		for ($i = 0; $i < 5; $i++) {
			App\Model\Base\MultiVariableLine::create([
				'variable_id' => $variable->id,
				'page_id' => $contact->id,
			]);
		}

		/** Get page
		 */
		$index = App\Model\Base\Page::whereHas('view', function ($q) {
			$q->where('title', 'Index');
		})->first();

		/** Get variables
		 */
		$variable = App\Model\Base\Variable::where('title', 'indexLinks')->first();

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		/** Get variables
		 */
		$variable = App\Model\Base\Variable::where('title', 'indexSlider')->first();
		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);

		App\Model\Base\MultiVariableLine::create([
			'variable_id' => $variable->id,
			'page_id' => $index->id,
		]);
	}
}
