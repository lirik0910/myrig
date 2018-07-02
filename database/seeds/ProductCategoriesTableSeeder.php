<?php

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$base = App\Model\Shop\Category::where('title', 'Base')->first();
		$secondary = App\Model\Shop\Category::where('title', 'Secondary')->first();

		$product = App\Model\Shop\Product::whereHas('page', function ($q) {
			$q->where('link', 'product/dragonmint-16-th-s-2');
		})->first();
		App\Model\Shop\ProductCategory::create([
			'product_id' => $product->id,
			'category_id' => $base->id,
		]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/antminer-s9-13-5th-s');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $base->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/antminer-d3-19-3gh-s');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $base->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/myrig1660');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/antrouter-r1');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/fan_6000rpm');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/beagle-bone-s9-t9-r4');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/data_18pin');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/plata-upravleniya-s5-s7');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/plata-upravleniya-s9-t9-r4');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/plata-upravlenia-d3-l3');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/beagle-s5-s7');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);

	// 	$product = App\Model\Shop\Product::whereHas('page', function ($q) {
	// 		$q->where('link', 'product/beagle-s5-s7');
	// 	})->first();
	// 	App\Model\Shop\ProductCategory::create([
	// 		'product_id' => $product->id,
	// 		'category_id' => $secondary->id,
	// 	]);
	 }
}
