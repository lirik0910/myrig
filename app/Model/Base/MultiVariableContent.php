<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class MultiVariableContent extends Model
{
	protected $guarded = [];
	
	/**
	 * Get multi variable field
	 * @return boolean
	 */
	public function multiVariable()
	{
		return $this->belongsTo(MultiVariable::class);
	}

	/**
	 * Transform multi variables collection content to array
	 * @param Illuminate\Database\Eloquent\Collection $collection
	 * @return array
	 */
	public static function multiConvert(Collection $collection) : array
	{
		$a = [];
		foreach ($collection as $var) {
			foreach ($var->multiVariableLines as $line) {
				$c = [];
				foreach ($line->content as $item) {
					if($item){
						$c[$item->multiVariable->title] = $item->content;
					}
				}
				$a[$var->title][] = $c;
			}
		}

		return $a;
	}
}
