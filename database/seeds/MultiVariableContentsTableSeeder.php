<?php

use Illuminate\Database\Seeder;

class MultiVariableContentsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** Get lines
		 */
		$lines = App\Model\Base\MultiVariableLine::whereHas('variable', function ($q) {
			$q->where('title', 'Contact items');
		})->get();

		/** Get variables
		 */
		$countryMultiVariable = App\Model\Base\MultiVariable::where('title', 'country')->first();
		$serviceMultiVariable = App\Model\Base\MultiVariable::where('title', 'serviceType')->first();
		$addressMultiVariable = App\Model\Base\MultiVariable::where('title', 'address')->first();
		$phoneMultiVariable = App\Model\Base\MultiVariable::where('title', 'phone')->first();
		$telegramMultiVariable = App\Model\Base\MultiVariable::where('title', 'telegram')->first();
		$latMultiVariable = App\Model\Base\MultiVariable::where('title', 'lat')->first();
		$lngMultiVariable = App\Model\Base\MultiVariable::where('title', 'lng')->first();

		$key = 0;
		foreach ($lines as $item) {
			if ($key == 0) {
				$country = 'USA';
				$service = 'Full service';
				$address = '3700 Quebec Street, Unit 100-239 Denver, Colorado 80207';
				$phone = '+1-844-248-62-46';
                $telegram = '';
				$lat = '39.768294';
				$lng = '-104.90209679999998';
			}

			if ($key == 1) {
				$country = 'RUSSIA';
				$service = 'Limited Service';
                $address = '';
				$phone = '+7 499 918-73-89';
				$telegram = '@myrigsales';
				$lat = '55.755826';
				$lng = '37.617299900000035';
			}

			if ($key == 2) {
				$country = 'UKRAINE';
				$service = 'Limited Service';
                $address = '';
				$phone = '+38 044 360-7958';
                $telegram = '@myrigsales';
				$lat = '50.4501';
				$lng = '30.523400000000038';
			}

			if ($key == 3) {
				$country = 'JAPAN';
				$service = 'Limited Service';
				$address = 'Minami 9 Jo Dori 26 chome 589-57 Asahikawa, Hokkaido 078-8339 Japan';
                $phone = '';
                $telegram = '';
				$lat = '43.745711849705884';
				$lng = '142.38409996032715';
			}

			if ($key == 4) {
				$country = 'VENEZUELA';
				$service = 'Very Limited Service';
                $address = '';
				$phone = '+58 0212 720-21-27';
                $telegram = '';
				$lat = '10.5072463';
				$lng = '-66.87855919999998';
			}

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $countryMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $country
			]);

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $serviceMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $service
			]);

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $addressMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $address
			]);

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $phoneMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $phone
			]);

            App\Model\Base\MultiVariableContent::create([
                'multi_variable_id' => $telegramMultiVariable->id,
                'multi_variable_line_id' => $item->id,
                'content' => $telegram
            ]);

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $latMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $lat
			]);

			App\Model\Base\MultiVariableContent::create([
				'multi_variable_id' => $lngMultiVariable->id,
				'multi_variable_line_id' => $item->id,
				'content' => $lng
			]);

			$key++;
		}
	}
}