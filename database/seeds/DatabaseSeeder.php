<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(PoliciesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(ComponentsTableSeeder::class);
		$this->call(ContextsTableSeeder::class);
		$this->call(ViewsTableSeeder::class);
		$this->call(PagesTableSeeder::class);
	}
}
