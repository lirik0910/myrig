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
		$contexts = App\Model\Base\Context::all();

		foreach ($contexts as $context){
            $checkoutPage = App\Model\Base\Page::whereHas('view', function ($q) {
                $q->where('title', 'Checkout');
            })->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.checkout_page',
                'value' => $checkoutPage->id
            ]);

            $cartPage = App\Model\Base\Page::whereHas('view', function ($q) {
                $q->where('title', 'Cart');
            })->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.shop_page',
                'value' => $cartPage->id
            ]);

            $productstPage = App\Model\Base\Page::whereHas('view', function ($q) {
                $q->where('title', 'Shop');
            })->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.products_page',
                'value' => $productstPage->id
            ]);

            $servicePage = App\Model\Base\Page::whereHas('view', function ($q) {
                $q->where('title', 'Service');
            })->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.service_page',
                'value' => $servicePage->id
            ]);

            $newsPage = App\Model\Base\Page::where('link', 'news')->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.news_page',
                'value' => $newsPage->id
            ]);

            $contactsPage = App\Model\Base\Page::whereHas('view', function ($q) {
                $q->where('title', 'Contacts');
            })->where('context_id', $context->id)->first();

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'site.contacts_page',
                'value' => $contactsPage->id
            ]);

            /** Custom rate settings
             */
            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'rate.value_type',
                'value' => 'usd'
            ]);

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'rate.value_size',
                'value' => 'max'
            ]);

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'rate.value_custom',
                'value' => '0'
            ]);

            App\Model\Base\Setting::create([
                'context_id' => $context->id,
                'title' => 'calculator.btc_network',
                'value' => ''
            ]);
        }

	}
}
