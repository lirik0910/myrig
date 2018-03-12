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
		$this->call(ProductCategoriesTableSeeder::class);
		$this->call(VendorsTableSeeder::class);
		$this->call(ProductsTableSeeder::class);
		$this->call(OrderStatusesTableSeeder::class);
		$this->call(PaymentTypesTableSeeder::class);
		$this->call(DeliveriesTableSeeder::class);
		$this->call(VariablesTableSeeder::class);
		$this->call(VariableContentsTableSeeder::class);
		$this->call(SettingsTableSeeder::class);
		$this->call(ProductOptionTypesTableSeeder::class);
		$this->call(ProductOptionsTableSeeder::class);
		$this->call(MultiVariablesTableSeeder::class);
		$this->call(MultiVariableLinesTableSeeder::class);
		$this->call(MultiVariableContentsTableSeeder::class);
		$this->call(ViewVariablesTableSeeder::class);
	}
}
