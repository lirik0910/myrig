<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
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

		/** Get default views
		 */
		$viewIndex = App\Model\Base\View::where('title', 'Index')->firstOrFail();
		$view404 = App\Model\Base\View::where('title', '404')->firstOrFail();
		$viewShop = App\Model\Base\View::where('title', 'Shop')->firstorFail();
		$viewArticleList = App\Model\Base\View::where('title', 'ArticleList')->firstOrFail();
		$viewService = App\Model\Base\View::where('title', 'Service')->firstorFail();
		$viewContacts = App\Model\Base\View::where('title', 'Contacts')->firstOrFail();
		$viewCart = App\Model\Base\View::where('title', 'Cart')->firstorFail();
		$viewProfile = App\Model\Base\View::where('title', 'Profile')->firstOrFail();
		$viewCalc = App\Model\Base\View::where('title', 'Calculator')->firstOrFail();
		$viewProduct = App\Model\Base\View::where('title', 'Product')->firstOrFail();
		$viewCheckout = App\Model\Base\View::where('title', 'Checkout')->firstOrFail();

		/** Get default user
		 */
		$user = App\Model\Base\User::where('name', 'admin')->firstOrFail();

		/** Add index page
		 */
		$index = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewIndex->id,
			'link' => '/',
			'title' => 'Index page',
			'description' => 'Site index page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		/** Add 404 page
		 */
		$error404 = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $view404->id,
			'link' => '404',
			'title' => '404',
			'description' => 'Page not found',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$products = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewShop->id,
			'link' => 'shop',
			'title' => 'Products',
			'description' => 'Products page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/dragonmint-16-th-s-2',
			'title' => 'DragonMint 16TH/s',
			'description' => 'DragonMint 16TH/s - the latest innovation on the Bitcoin mining market, created by Halong Mining',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/antminer-s9-13-5th-s',
			'title' => 'ANTMINER S9 13.5TH/s',
			'description' => 'Antminer S9 - one of the latest innovations in the line of miners, produced by Bitmain',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/antminer-d3-19-3gh-s',
			'title' => 'ANTMINER D3 19.3GH/s',
			'description' => 'Antminer D3 - equipment for mining, developed by specialists BITMAIN.',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/myrig1660',
			'title' => 'BP MYRIG 12V 1680W',
			'description' => 'BP MYRIG provide a maximum power of 1240 watts if it is connected to a 110 V network power supply.',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/antrouter-r1',
			'title' => 'AntRouter R1',
			'description' => 'AntRouter R1 is a wireless network device that contains a chip for bitcoins',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/plata-upravlenia-d3-l3',
			'title' => 'Control board D3 / L3',
			'description' => 'Control board D3 / L3',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/fan_6000rpm',
			'title' => '6000RPM Fan',
			'description' => '6000RPM Fan',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/beagle-bone-s9-t9-r4',
			'title' => 'Beagle Bone S9/T9/R4',
			'description' => 'Beagle Bone S9/T9/R4',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/data_18pin',
			'title' => 'Data 18 pin cable',
			'description' => 'Data 18 pin cable',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/plata-upravleniya-s5-s7',
			'title' => 'Control board S5 / S7',
			'description' => 'Control board S5 / S7',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/plata-upravleniya-s9-t9-r4',
			'title' => 'Control board S9 / T9 / R4',
			'description' => 'Control board S9 / T9 / R4',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		App\Model\Base\Page::create([
			'parent_id' => $products->id,
			'context_id' => $context->id,
			'view_id' => $viewProduct->id,
			'link' => 'product/beagle-s5-s7',
			'title' => 'Beagle Bone S5/S7',
			'description' => 'Beagle Bone S5/S7',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$news = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewArticleList->id,
			'link' => 'news',
			'title' => 'News',
			'description' => 'News page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$article = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewArticleList->id,
			'link' => 'info',
			'title' => 'Articles',
			'description' => 'Articles page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$service = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewService->id,
			'link' => 'service',
			'title' => 'Service',
			'description' => 'Service page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$contacts = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewContacts->id,
			'link' => 'contacts',
			'title' => 'Contacts',
			'description' => 'Contacts page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$cart = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewCart->id,
			'link' => 'cart',
			'title' => 'Cart',
			'description' => 'Client cart page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$profile = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewProfile->id,
			'link' => 'profile',
			'title' => 'Profile',
			'description' => 'Client profile page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$calculator = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewCalc->id,
			'link' => 'calculator',
			'title' => 'Calculator',
			'description' => 'Calculator page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		$checkout = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewCheckout->id,
			'link' => 'checkout',
			'title' => 'Checkout',
			'description' => 'Checkout page',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);
	}
}
