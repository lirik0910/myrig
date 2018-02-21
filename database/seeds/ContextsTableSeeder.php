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
		App\Context::create([
			'title' => 'Base',
			'description' => 'Базовый контекст'
		]);
	}
}
