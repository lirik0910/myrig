<?php

use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Base\Action::create([
			'name' => 'login_manager',
			'description' => 'Allow enter to manager',
		]);

		App\Model\Base\Action::create([
			'name' => 'page_collection',
			'description' => 'Allow get page collection',
		]);

		App\Model\Base\Action::create([
			'name' => 'page_one',
			'description' => 'Allow get page model',
		]);

		App\Model\Base\Action::create([
			'name' => 'page_create',
			'description' => 'Allow create new page model',
		]);

		App\Model\Base\Action::create([
			'name' => 'page_edit',
			'description' => 'Allow edit page model',
		]);

		App\Model\Base\Action::create([
			'name' => 'page_delete',
			'description' => 'Allow delete page model',
		]);

		App\Model\Base\Action::create([
			'name' => 'user_collection',
			'description' => 'Allow get user collection',
		]);

		App\Model\Base\Action::create([
			'name' => 'user_one',
			'description' => 'Allow get user model',
		]);

		App\Model\Base\Action::create([
			'name' => 'user_create',
			'description' => 'Allow create new user model',
		]);

		App\Model\Base\Action::create([
			'name' => 'user_edit',
			'description' => 'Allow edit user model',
		]);

		App\Model\Base\Action::create([
			'name' => 'user_delete',
			'description' => 'Allow delete user model',
		]);

		// App\Model\Base\Action::create([
		// 	'name' => 'user_policy',
		// 	'description' => 'Allow change access policy for user model',
		// ]);

		App\Model\Base\Action::create([
			'name' => 'product_collection',
			'description' => 'Allow get product collection',
		]);

		App\Model\Base\Action::create([
			'name' => 'product_one',
			'description' => 'Allow get product model',
		]);

		App\Model\Base\Action::create([
			'name' => 'product_create',
			'description' => 'Allow create new product model',
		]);

		App\Model\Base\Action::create([
			'name' => 'product_edit',
			'description' => 'Allow edit product model',
		]);

		App\Model\Base\Action::create([
			'name' => 'product_delete',
			'description' => 'Allow delete product model',
		]);

		App\Model\Base\Action::create([
			'name' => 'order_collection',
			'description' => 'Allow get order collection',
		]);

		App\Model\Base\Action::create([
			'name' => 'order_one',
			'description' => 'Allow get order model',
		]);

		App\Model\Base\Action::create([
			'name' => 'order_create',
			'description' => 'Allow create new order model',
		]);

		App\Model\Base\Action::create([
			'name' => 'order_edit',
			'description' => 'Allow edit order model',
		]);

		App\Model\Base\Action::create([
			'name' => 'order_delete',
			'description' => 'Allow delete order model',
		]);

		App\Model\Base\Action::create([
			'name' => 'file_list',
			'description' => 'Allow see file list',
		]);

		App\Model\Base\Action::create([
			'name' => 'file_edit',
			'description' => 'Allow edit file',
		]);

		App\Model\Base\Action::create([
			'name' => 'file_create',
			'description' => 'Allow upload new file',
		]);

		App\Model\Base\Action::create([
			'name' => 'file_delete',
			'description' => 'Allow delete file',
		]);

		App\Model\Base\Action::create([
			'name' => 'folder_list',
			'description' => 'Allow see folder list',
		]);

		App\Model\Base\Action::create([
			'name' => 'folder_edit',
			'description' => 'Allow edit folder',
		]);

		App\Model\Base\Action::create([
			'name' => 'folder_create',
			'description' => 'Allow create folder',
		]);

		App\Model\Base\Action::create([
			'name' => 'folder_delete',
			'description' => 'Allow delete folder',
		]);

		App\Model\Base\Action::create([
			'name' => 'vocabulary_list',
			'description' => 'Allow see vocabulary list',
		]);

		App\Model\Base\Action::create([
			'name' => 'vocabulary_edit',
			'description' => 'Allow edit word',
		]);

		App\Model\Base\Action::create([
			'name' => 'cache_clear',
			'description' => 'Allow clear cache',
		]);
	}
}
