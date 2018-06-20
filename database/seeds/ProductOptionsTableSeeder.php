<?php

use Illuminate\Database\Seeder;

class ProductOptionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
/*		$video = App\Model\Shop\ProductOptionType::where('title', 'video')->first();
		$warranty = App\Model\Shop\ProductOptionType::where('title', 'warranty')->first();
		$secondary = App\Model\Shop\ProductOptionType::where('title', 'secondary')->first();
		$recoupment = App\Model\Shop\ProductOptionType::where('title', 'recoupment')->first();
		$characteristic = App\Model\Shop\ProductOptionType::where('title', 'characteristic')->first();
		$currency = App\Model\Shop\ProductOptionType::where('title', 'currency')->first();

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/dragonmint-16-th-s-2');
		})->first();
		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Hashrate',
			'value' => '16 TH/s',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy eff',
			'value' => '0.075 J / Gx',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy consumption',
			'value' => '1432W',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Number of chips',
			'value' => '189*DM8575',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Rated voltage',
			'value' => '11.6 ~ 13V',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Cooling',
			'value' => '2 Fans: 6000ob/m',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Dimensions',
			'value' => '340 x 125 x 155 mm',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Weight',
			'value' => '6 kg',
		]);

        App\Model\Shop\ProductOption::create([
            'product_id' => $product->id,
            'type_id' => $currency->id,
            'name' => 'Currency',
            'value' => 'BTC',
        ]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antminer-s9-13-5th-s');
		})->first();
		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Hashrate',
			'value' => '13.5Тh ± 5%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy eff',
			'value' => '0.098 J / Gx',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy consumption',
			'value' => '1323W + 10%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Number of chips',
			'value' => '189хBM1387',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Rated voltage',
			'value' => '11.6 ~ 13V',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Cooling',
			'value' => '2 Fans: 6000ob/m, 4300об/m',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Working conditions',
			'value' => 'from 0 ° C to 40 ° C',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Dimensions',
			'value' => '350 x 135 x 158 mm',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $video->id,
			'name' => 'Video',
			'value' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/-yfUQsg9ntQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>',
		]);

        App\Model\Shop\ProductOption::create([
            'product_id' => $product->id,
            'type_id' => $currency->id,
            'name' => 'Currency',
            'value' => 'BTC',
        ]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antminer-d3-19-3gh-s');
		})->first();
		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Hashrate',
			'value' => '19.3Gh ± 5%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy eff',
			'value' => '80Вт/1Gh',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy consumption',
			'value' => '1200W + 10%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Rated voltage',
			'value' => '11.6 ~ 13V',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Cooling',
			'value' => 'Fans: 6000ob/m, 4300об/m',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Working conditions',
			'value' => 'from 0 ° C to 40 ° C',
		]);

        App\Model\Shop\ProductOption::create([
            'product_id' => $product->id,
            'type_id' => $currency->id,
            'name' => 'Currency',
            'value' => 'DASH',
        ]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/myrig1660');
		})->first();
		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Power',
			'value' => '1680W',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Type of connection',
			'value' => '10 PCIe',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Efficiency',
			'value' => '93%(80 Plus Platinum)',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Dimensions',
			'value' => '40mm x 107mm x 280mm',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antrouter-r1');
		})->first();
		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'WiFi standard',
			'value' => '802.11g/n, 2.4G',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Maximum connection speed',
			'value' => '150MB/s',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Type of chip',
			'value' => 'BM1485',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Hashrate',
			'value' => '1.29MH/s',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy consumption',
			'value' => '3.78W +2.9%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Energy eff',
			'value' => '2.93 J/MH +2.9%',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Voltage',
			'value' => '100-220V',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Input current',
			'value' => '0.2A',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'USB port voltage',
			'value' => '5V',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Working conditions',
			'value' => '0 — 40°C',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Dimensions of the router',
			'value' => '84.5mm x 56.6mm x 29mm',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Package size',
			'value' => '110.5mm x 82mm x 40mm',
		]);

		App\Model\Shop\ProductOption::create([
			'product_id' => $product->id,
			'type_id' => $characteristic->id,
			'name' => 'Weight',
			'value' => '148 grams',
		]);*/
	}
}
