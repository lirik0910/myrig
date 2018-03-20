<?php

namespace App\Model\Shop;

use App\Model\Base\Setting;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
	protected $guarded = [];

	/** 
	 * Count custom BTC rate
	 * @return boolean
	 */
	public function countCustomRate()
	{
		if ($this->title !== 'BTC/USD')
			return false;

		$shop = ExchangeRate::where('title', 'coinbase')
				->orWhere('title', 'blockchain')
				->orWhere('title', 'bitstamp')
				->get();

		//print_r($shop->toArray());

		$valueType = Setting::where('title', 'rate.value_type')->first();
		$valueSize = Setting::where('title', 'rate.value_size')->first();
		$valueCustom = Setting::where('title', 'rate.value_custom')->first();

		$total = 0;
		if ($valueSize->value === 'max') {
			foreach ($shop as $item) {
				$v = (float) $item->value;

				if ($total < $v) {
					$total = $v;
				}
			}
		}

		if ($valueSize->value === 'min') {
			$first = $shop->first();
			$total = (float) $first->value;

			foreach ($shop as $item) {
				$v = (float) $item->value;
				if ($total > $v) {
					$total = $v;
				}
			}
		}

		if ($valueType->value === 'usd') {
			$total = $total + (float) $valueCustom->value;
		}

		if ($valueType->value === 'percent') {
			$x = ((float) $valueCustom->value * $total) / 100;
			$total = $total + $x;
		}

		$this->value = $total;
		return true;
	}
}
