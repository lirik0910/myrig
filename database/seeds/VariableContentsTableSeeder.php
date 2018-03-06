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
		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => 'The quantity is limited!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => 'Shipment from the factory in China April 20 - May 10.'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => '100% advance payment in BTC!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => 'Final price check with the manager!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => 'Warranty service: 1-5 days'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 10,
			'variable_id' => 1,
			'content' => 'Local delivery in Ukraine'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => 'The quantity is limited!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => 'Shipment from the factory in China April 20 - May 10.'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => '100% advance payment in BTC!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => 'Final price check with the manager!'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => 'Warranty service: 1-5 days'
		]);

		App\Model\Base\VeriableContent::create([
			'page_id' => 11,
			'variable_id' => 1,
			'content' => 'Local delivery in Ukraine'
		]);
	}
}
