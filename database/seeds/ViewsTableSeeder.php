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
		App\View::create([
			'title' => 'Index',
			'description' => 'Шаблон главной страницы',
			'path' => '/content/index.blade.php'
		]);

		/** Add 404 view
		 */
		App\View::create([
			'title' => '404',
			'description' => 'Шаблон страницы 404',
			'path' => '/content/404.blade.php'
		]);
	}
}
