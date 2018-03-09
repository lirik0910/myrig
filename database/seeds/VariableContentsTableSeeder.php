<?php

use Illuminate\Database\Seeder;

class VariableContentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$variable = App\Model\Base\Variable::where('title', 'Product information items')->first();

		$pages = App\Model\Base\Page::whereHas('view', function ($q) {
			$q->where('title', 'Product');
		})->get();

		foreach ($pages as $item) {
			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => 'The quantity is limited!'
			]);

			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => 'Shipment from the factory in China April 20 - May 10.'
			]);

			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => '100% advance payment in BTC!'
			]);

			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => 'Final price check with the manager!'
			]);

			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => 'Warranty service: 1-5 days'
			]);

			App\Model\Base\VariableContent::create([
				'page_id' => $item->id,
				'variable_id' => $variable->id,
				'content' => 'Local delivery in Ukraine'
			]);
		}
	}
}
