<?php

use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Model\Shop\OrderStatus::create([
			'title' => 'New order',
			'description' => 'New order',
			'color' => '#ED1E1E',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Processing',
			'description' => 'Order in the processing stage',
			'color' => '#4B21C6',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Waiting for payment',
			'description' => 'The order is waiting for payment',
			'color' => '#EAAD2A',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Has been paid',
			'description' => 'Order has been paid',
			'color' => '#7745AD',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Shipped by the factory',
			'description' => 'The order was shipped by the factory',
			'color' => '#380808',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'In a local warehouse',
			'description' => 'Order in a local warehouse',
			'color' => '#7f5B00',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Completed',
			'description' => 'Order completed',
			'color' => '#2DA52B',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Returned',
			'description' => 'Order returned',
			'color' => '#424242',
			'active' => 1
		]);

		App\Model\Shop\OrderStatus::create([
			'title' => 'Сancelled',
			'description' => 'Order cancelled',
			'color' => '#703535',
			'active' => 1
		]);
	}
}
