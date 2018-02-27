<?php

use Illuminate\Database\Seeder;

class ContextsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Add base context
		 */
		App\Model\Base\Context::create([
			'title' => 'Base',
			'description' => 'Base context'
		]);

		/** Add ua context
		 */
		App\Model\Base\Context::create([
			'title' => 'UA',
			'description' => 'UA context'
		]);

		/** Add ru context
		 */
		App\Model\Base\Context::create([
			'title' => 'RU',
			'description' => 'RU context'
		]);
	}
}
