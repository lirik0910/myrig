<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;

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
	    //var_dump($collection); die;
        $locale = App::getLocale();
        //var_dump($locale); die;
		$a = [];
		foreach ($collection as $var) {
		    //var_dump($var); die;
			foreach ($var->multiVariableLines as $line) {
			    //var_dump(strtolower($line->page->context->title)); //die;
			    if(strtolower($line->page->context->title) == $locale){
                    $c = [];
                    foreach ($line->content as $item) {
                        //var_dump($item); die;
                        if($item){
                            $c[$item->multiVariable->title] = $item->content;
                        }
                    }
                    $a[$var->title][] = $c;
                }

			}
			//die;
		}
		//var_dump($a); die;

		return $a;
	}
}
