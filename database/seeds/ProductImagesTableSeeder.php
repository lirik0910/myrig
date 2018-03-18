<?php

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/dragonmint-16-th-s-2');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/dragonmint-t1-16th-s/1.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/dragonmint-t1-16th-s/2.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/dragonmint-t1-16th-s/3.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/dragonmint-t1-16th-s/4.jpg',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antminer-s9-13-5th-s');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-s9-13.5th-s/1.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-s9-13.5th-s/2.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-s9-13.5th-s/3.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-s9-13.5th-s/4.png',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antminer-d3-19-3gh-s');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-d3-19.3-gh-s/1.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-d3-19.3-gh-s/2.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-d3-19.3-gh-s/3.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antminer-d3-19.3-gh-s/4.jpg',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/myrig1660');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/bp-myrig-12v-1680w/1.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/bp-myrig-12v-1680w/2.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/bp-myrig-12v-1680w/3.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/bp-myrig-12v-1680w/4.png',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/antrouter-r1');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antrouter-r1/1.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antrouter-r1/2.png',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/antrouter-r1/3.png',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/plata-upravlenia-d3-l3');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/blade-conrol-d3-l3/1.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/blade-conrol-d3-l3/2.jpg',
		]);

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/blade-conrol-d3-l3/3.jpg',
		]);

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/fan_6000rpm');
		})->first();

		App\Model\Shop\ProductImage::create([
			'product_id' => $product->id,
			'name' => 'product/6000rpm-fan/1.png',
		]);
	}
}
