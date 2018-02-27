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
	}
}
