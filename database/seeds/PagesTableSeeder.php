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
		$context = App\Context::where('title', 'Base')->firstOrFail();

		/** Get default views
		 */
		$viewIndex = App\View::where('title', 'Index')->firstOrFail();
		$view404 = App\View::where('title', '404')->firstOrFail();

		/** Get default user
		 */
		$user = App\User::where('name', 'admin')->firstOrFail();

		/** Add index page
		 */
		$index = App\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $viewIndex->id,
			'link' => '/',
			'title' => 'Главная',
			'description' => 'Главная страница сайта',
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
		$index = App\Page::create([
			'parent_id' => 0,
			'context_id' => $context->id,
			'view_id' => $view404->id,
			'link' => '/',
			'title' => 'Главная',
			'description' => 'Главная страница сайта',
			'introtext' => '',
			'content' => '',
			'createdby_id' => $user->id,
			'updatedby_id' => $user->id
		]);

		/** Relations
		 */
		$index->context()->associate($context);
		$index->view()->associate($view404);
	}
}
