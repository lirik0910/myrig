<?php

use Illuminate\Database\Seeder;

class PolicyActionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$admin = App\Model\Base\Policy::where('name', 'Admin')->first();
		$all = App\Model\Base\Action::all();
		foreach ($all as $item) {
			App\Model\Base\PolicyAction::create([
				'policy_id' => $admin->id,
				'action_id' => $item->id,
			]);
		}

		$manager = App\Model\Base\Policy::where('name', 'Manager')->first();
		foreach ($all as $item) {
			App\Model\Base\PolicyAction::create([
				'policy_id' => $manager->id,
				'action_id' => $item->id,
			]);
		}

		$member = App\Model\Base\Policy::where('name', 'Member')->first();
		foreach($all as $item) {
			switch ($item->name) {
				case 'page_collection':
				case 'page_one':
				case 'product_collection':
				case 'product_one':
				case 'order_one':
				case 'order_create':
					App\Model\Base\PolicyAction::create([
						'policy_id' => $member->id,
						'action_id' => $item->id,
					]);
					break;
			}
		}
	}
}
