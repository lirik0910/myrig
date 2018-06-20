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
		//$context = App\Model\Base\Context::where('title', 'Base')->firstOrFail();
		$contexts = App\Model\Base\Context::all();

		/** Get default views
		 */
		$viewIndex = App\Model\Base\View::where('title', 'Index')->firstOrFail();
		$view404 = App\Model\Base\View::where('title', '404')->firstOrFail();
		$viewShop = App\Model\Base\View::where('title', 'Shop')->firstorFail();
		$viewArticleList = App\Model\Base\View::where('title', 'News')->firstOrFail();
		$viewService = App\Model\Base\View::where('title', 'Service')->firstOrFail();
		$viewContacts = App\Model\Base\View::where('title', 'Contacts')->firstOrFail();
		$viewCart = App\Model\Base\View::where('title', 'Cart')->firstOrFail();
		$viewProfile = App\Model\Base\View::where('title', 'Profile')->firstOrFail();
		$viewCalc = App\Model\Base\View::where('title', 'Calculator')->firstOrFail();
		$viewProduct = App\Model\Base\View::where('title', 'Product')->firstOrFail();
		$viewCheckout = App\Model\Base\View::where('title', 'Checkout')->firstOrFail();
		$viewCheckoutSuccess = App\Model\Base\View::where('title', 'Checkout success')->firstOrFail();

		/** Get default user
		 */
		$user = App\Model\Base\User::where('name', 'admin')->firstOrFail();

		foreach ($contexts as $context){
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
                'content' => '          <p>The modern world of crypto currency is reliable, secure and promising. The high level of its protection is due to decentralization of the accounting system and emissions, as well as functioning in a distributed computer network. You can earn the crypt by means of specialized devices - ASIC-miners and GPU-farms. Their main purpose is the calculation of algorithms: SHA-256, X11, Scrypt, etc.</p>
                                    <p>The acquisition of new equipment for mining is carried out on the basis of calculations of future profits and expenses for energy consumed. Such calculations are considered quite laborious, in particular, when it is required to compare several types of devices. On the site, each user will be able to use a unique tool for automatic operations calculating the profit of miners and the level of electricity consumption.</p>
                                    <h2>Cryptographic currency calculator: ease of use</h2>
                                    <p>Use the crypto-currencies calculator (Bitcoin, Litecoin, Etherium, Dash) is simple enough. To do this, select the appropriate ASIC-Miner / GPU-farm from the drop-down menu or enter the hardware hash and press the "Calculate" button. As a result, the calculator will provide full information about the consumption of the miner, as well as all information about the earnings of the crypto currency with its automatic conversion into dollars, rubles, hryvnia, etc. At the same time, this tool is not limited to general data; it provides tables in which information on daily, weekly, monthly earnings in any desired currency is structured, as well as on the consumption of electricity in similar time ranges.</p>
                                    <p>The calculator Kriplo-currency can significantly simplify the process of selecting the required equipment for mining by saving time on the calculations. As noted earlier, there is a drop-down list with miners in the calculator. All of them are presented in the store, therefore, after making a quick calculation, you can immediately find the optimal version of the ASIC-miner, after which you will be engaged in the crypto-currency mining.</p>
                                    <p><span style="color: #999999;"><em>*Absolute accuracy of exchange rates presented in the cryptocalculator is not guaranteed (this does not even help the minute synchronization with the largest crypto-exchange exchanges). That\'s why before making certain transactions, users should check the exchange rate to avoid unforeseen situations. It should be noted that the exchange rate of crypto currency is determined by the data received online from API exchanges. Such exchange rates are informational in nature, so they can change spontaneously, that is without prior notice. By the way, due to the constant fluctuations of the exchange rate, we are not responsible for the transactions made on the given data. All displayed information on exchange rates is not intended for use in investment transactions.</em></span></p>
			',
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

            $checkout_success = App\Model\Base\Page::create([
                'parent_id' => 0,
                'context_id' => $context->id,
                'view_id' => $viewCheckoutSuccess->id,
                'link' => 'checkout/order_success',
                'title' => 'Checkout success',
                'description' => 'Checkout success page',
                'introtext' => '',
                'content' => '',
                'createdby_id' => $user->id,
                'updatedby_id' => $user->id
            ]);
        }

	}
}
