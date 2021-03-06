<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add dashboard component
		 */
		App\Model\Base\Component::create([
			'name' => 'Statistic',
			'description' => 'Site statistic',
			'link' => '/',
			'icon' => 'Home'
		]);

		/** Add pages component
		 */
		App\Model\Base\Component::create([
			'name' => 'Pages',
			'description' => 'Site pages',
			'link' => '/pages',
			'icon' => 'ContentCopy'
		]);

		/** Add users component
		 */
		App\Model\Base\Component::create([
			'name' => 'Users',
			'description' => 'Manage users',
			'link' => '/users',
			'icon' => 'People'
		]);

		/** Add views component
		 */
		/*App\Model\Base\Component::create([
			'name' => 'Views',
			'description' => 'Site view templates',
			'link' => '/views',
			'icon' => 'ViewCompact'
		]);*/

		/** Add settings component
		 */
		/*App\Model\Base\Component::create([
			'name' => 'Settings',
			'description' => 'Site settings',
			'link' => '/settings',
			'icon' => 'Settings'
		]);*/

		/** Add orders component
		 */
		App\Model\Base\Component::create([
			'name' => 'Orders',
			'description' => 'Order list',
			'link' => '/orders',
			'icon' => 'Assignment'
		]);

		/** Add products component
		 */
		App\Model\Base\Component::create([
			'name' => 'Products',
			'description' => 'Shop products',
			'link' => '/products',
			'icon' => 'Store'
		]);

		/** Add tickets component
		 */
		/*App\Model\Base\Component::create([
			'name' => 'Tickets',
			'description' => 'Ticket list',
			'link' => '/tickets',
			'icon' => 'Chat'
		]);*/

		/** Add file manager component
		 */
		App\Model\Base\Component::create([
			'name' => 'Files',
			'description' => 'File manager',
			'link' => '/files',
			'icon' => 'Photo'
		]);

		App\Model\Base\Component::create([
			'name' => 'BTC Rates',
			'description' => 'BTC Rates',
			'link' => '/rates',
			'icon' => 'Timeline'
		]);

		App\Model\Base\Component::create([
			'name' => 'Create news',
			'description' => 'Create news',
			'link' => '/pages/create?parent_id=16&context_id=1&link=news&view_id=10',
			'icon' => 'Textsms'
		]);

		App\Model\Base\Component::create([
			'name' => 'Create article',
			'description' => 'Create article',
			'link' => '/pages/create?parent_id=17&context_id=1&link=info&view_id=10',
			'icon' => 'Textsms'
		]);

        /** Add notifications component
         */
        App\Model\Base\Component::create([
            'name' => 'Notifications',
            'description' => 'Manage notifications',
            'link' => '/notifications',
            'icon' => 'Notifications'
        ]);
	}
}
