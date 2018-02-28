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
       // $viewProfile = App\Model\Base\View::where('title', 'Profile')->firstOrFail();
        $viewCalc = App\Model\Base\View::where('title', 'Calculator')->firstOrFail();

		/** Get default user
		 */
		$user = App\User::where('name', 'admin')->firstOrFail();

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

		/** Relations
		 */
		$index->context()->associate($context);
		$index->view()->associate($viewIndex);

		/** Add 404 page
		 */
		$index = App\Model\Base\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $view404->id,
			'link' => '/404',
			'title' => '404',
			'description' => 'Page not found',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		/** Relations
		 */
		$index->context()->associate($context);
		$index->view()->associate($view404);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewShop->id,
            'link' => '/shop',
            'title' => 'Products',
            'description' => 'Products page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewShop);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewArticleList->id,
            'link' => '/news',
            'title' => 'News',
            'description' => 'News page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewArticleList);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewArticleList->id,
            'link' => '/info',
            'title' => 'Articles',
            'description' => 'Articles page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewArticleList);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewService->id,
            'link' => '/service',
            'title' => 'Service',
            'description' => 'Service page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewService);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewContacts->id,
            'link' => '/contacts',
            'title' => 'Contacts',
            'description' => 'Contacts page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewContacts);

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewCart->id,
            'link' => '/cart',
            'title' => 'Cart',
            'description' => 'Client cart page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewCart);

        /*$index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewProfile->id,
            'link' => '/profile',
            'title' => 'Profile',
            'description' => 'Client profile page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        /*$index->context()->associate($context);
        $index->view()->associate($viewProfile);*/

        $index = App\Model\Base\Page::create([
            'parent_id' => 0,
            'context_id' => $context->id,
            'view_id' => $viewCalc->id,
            'link' => '/calculator',
            'title' => 'Calculator',
            'description' => 'Calculator page',
            'introtext' => '',
            'content' => '',
            'createdby_id' => $user->id,
            'updatedby_id' => $user->id
        ]);

        /** Relations
         */
        $index->context()->associate($context);
        $index->view()->associate($viewCalc);
	}
}
