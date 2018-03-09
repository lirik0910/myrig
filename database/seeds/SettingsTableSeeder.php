<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Get base context
		 */
		$context = App\Model\Base\Context::where('title', 'Base')->firstOrFail();

		$checkoutPage = App\Model\Base\Page::whereHas('view', function ($q) {
			$q->where('title', 'Checkout');
		})->first();

		App\Model\Base\Setting::create([
			'context_id' => $context->id,
			'title' => 'site.checkout_page',
			'value' => $checkoutPage->id
		]);

		$cartPage = App\Model\Base\Page::whereHas('view', function ($q) {
			$q->where('title', 'Cart');
		})->first();

		App\Model\Base\Setting::create([
			'context_id' => $context->id,
			'title' => 'site.shop_page',
			'value' => $cartPage->id
		]);
	}
}
