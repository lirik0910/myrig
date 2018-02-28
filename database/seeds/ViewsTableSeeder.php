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
			'path' => '/content/index.blade.php'
		]);

		/** Add 404 view
		 */
		App\Model\Base\View::create([
			'title' => '404',
			'description' => 'Template for 404 page',
			'path' => '/content/404.blade.php'
		]);

        /** Add Shop view
         */
        App\Model\Base\View::create([
            'title' => 'Shop',
            'description' => 'Template for shop page',
            'path' => '/content/shop.blade.php'
        ]);

        /** Add Service view
         */
        App\Model\Base\View::create([
            'title' => 'Service',
            'description' => 'Template for service page',
            'path' => '/content/service.blade.php'
        ]);

        /** Add Product view
         */
        App\Model\Base\View::create([
            'title' => 'Product',
            'description' => 'Template for product page',
            'path' => '/content/product.blade.php'
        ]);

        /** Add ArticleList view
         */
        App\Model\Base\View::create([
            'title' => 'ArticleList',
            'description' => 'Template for news/info page',
            'path' => '/content/news.blade.php'
        ]);

        /** Add Contacts view
         */
        App\Model\Base\View::create([
            'title' => 'Contacts',
            'description' => 'Template for contacts page',
            'path' => '/content/contacts.blade.php'
        ]);

        /** Add Cart view
         */
        App\Model\Base\View::create([
            'title' => 'Cart',
            'description' => 'Template for cart page',
            'path' => '/content/cart.blade.php'
        ]);

        /** Add Calculator view
         */
        App\Model\Base\View::create([
            'title' => 'Calculator',
            'description' => 'Template for calculator page',
            'path' => '/content/calc.blade.php'
        ]);

        /** Add Article view
         */
        App\Model\Base\View::create([
            'title' => 'Article',
            'description' => 'Template for article page',
            'path' => '/content/article.blade.php'
        ]);
	}
}
