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

		$page = App\Model\Base\Page::where('link', 'product/dragonmint-16-th-s-2')->first();
		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'The quantity is limited!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Shipment from the factory in China April 20 - May 10.'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => '100% advance payment in BTC!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Final price check with the manager!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Warranty service: 1-5 days'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Local delivery in Ukraine'
		]);

		$page = App\Model\Base\Page::where('link', 'product/antminer-s9-13-5th-s')->first();
		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'The quantity is limited!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Final price check with the manager!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Warranty service: 1-3 days'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Local delivery in Ukraine'
		]);

		$page = App\Model\Base\Page::where('link', 'product/antminer-d3-19-3gh-s')->first();
		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'The quantity is limited!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Shipment from the factory in China 21 - 30 November'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => '100% advance payment in BTC!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Final price check with the manager!'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Warranty service: 1-3 days'
		]);

		App\Model\Base\VariableContent::create([
			'page_id' => $page->id,
			'variable_id' => $variable->id,
			'content' => 'Local delivery in Russia'
		]);

        $variable = App\Model\Base\Variable::where('title', 'Min/Max')->first();
        $page = App\Model\Base\Page::where('link', 'cart')->first();

        App\Model\Base\VariableContent::create([
            'page_id' => $page->id,
            'variable_id' => $variable->id,
            'content' => 'min'
        ]);

        $variable = App\Model\Base\Variable::where('title', 'USD/Percent')->first();
        $page = App\Model\Base\Page::where('link', 'cart')->first();

        App\Model\Base\VariableContent::create([
            'page_id' => $page->id,
            'variable_id' => $variable->id,
            'content' => 'usd'
        ]);

        $variable = App\Model\Base\Variable::where('title', 'Value/Change')->first();
        $page = App\Model\Base\Page::where('link', 'cart')->first();

        App\Model\Base\VariableContent::create([
            'page_id' => $page->id,
            'variable_id' => $variable->id,
            'content' => ''
        ]);
	}
}
