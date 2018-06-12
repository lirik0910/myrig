<?php

use Illuminate\Database\Seeder;

class ViewsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add index view
		 */
		App\Model\Base\View::create([
			'title' => 'Index',
			'description' => 'Template for index page',
			'path' => 'content/index'
		]);

		/** Add 404 view
		 */
		App\Model\Base\View::create([
			'title' => '404',
			'description' => 'Template for 404 page',
			'path' => 'content/404'
		]);

		/** Add Shop view
		 */
		App\Model\Base\View::create([
			'title' => 'Shop',
			'description' => 'Template for shop page',
			'path' => 'content/shop'
		]);

		/** Add Service view
		 */
		App\Model\Base\View::create([
			'title' => 'Service',
			'description' => 'Template for service page',
			'path' => 'content/service'
		]);

		/** Add Product view
		 */
		App\Model\Base\View::create([
			'title' => 'Product',
			'description' => 'Template for product page',
			'path' => 'content/product'
		]);

		/** Add ArticleList view
		 */
		App\Model\Base\View::create([
			'title' => 'News',
			'description' => 'Template for news/info page',
			'path' => 'content/news'
		]);

		/** Add Contacts view
		 */
		App\Model\Base\View::create([
			'title' => 'Contacts',
			'description' => 'Template for contacts page',
			'path' => 'content/contacts'
		]);

		/** Add Cart view
		 */
		App\Model\Base\View::create([
			'title' => 'Cart',
			'description' => 'Template for cart page',
			'path' => 'content/cart'
		]);

		/** Add Calculator view
		 */
		App\Model\Base\View::create([
			'title' => 'Calculator',
			'description' => 'Template for calculator page',
			'path' => 'content/calc'
		]);

		/** Add Article view
		 */
		App\Model\Base\View::create([
			'title' => 'Article',
			'description' => 'Template for article page',
			'path' => 'content/article'
		]);

		/** Add Article view
		 */
		App\Model\Base\View::create([
			'title' => 'Profile',
			'description' => 'Template for article page',
			'path' => 'content/profile'
		]);

		/** Add Checkout view
		 */
		App\Model\Base\View::create([
			'title' => 'Checkout',
			'description' => 'Template for checkout page',
			'path' => 'content/checkout'
		]);

        App\Model\Base\View::create([
            'title' => 'Checkout success',
            'description' => 'Template for checkout success page',
            'path' => 'content/checkoutSuccess'
        ]);
	}
}
