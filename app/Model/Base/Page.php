<?php

namespace App\Model\Base;

use App\Model\Shop\Product;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Page extends Model
{
	protected $guarded = [];

	/**
	 * Bind page with context model
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(View::class);
	}

	/**
	 * Bind page with view
	 * @return boolean
	 */
	public function view()
	{
		return $this->belongsTo(View::class);
	}

	public function variables(){
	    return $this->belongsToMany(Variable::class, 'variable_contents')->withPivot('content', 'name');
    }


    /*
     * Bind with Variable and Variable multi content model
     * return boolean
     */
    public function multivariables(){
        return $this->belongsToMany(Variable::class, 'variable_multi_contents')->withPivot('name', 'content', 'content_id');
    }

	public function getContent(string $link){
        $page = $this->where(['link' => $link])->with('view', 'variables', 'multivariables')->first();

        if(!$page){
            return view('content/404');
        }

        $output = [];

        $output ['viewName'] = explode('.', $page->view->path)[0];
        $output['data']['page'] = $page;
        $output['data']['settings'] = Setting::where(['context_id' => $page->context_id])->get();

        $migx = [];
        foreach ($page->multivariables as $mv){
            $migx[$mv->title][$mv->pivot->content_id][$mv->pivot->name] = $mv->pivot->content;
        }
        $output['data']['migx'] = $migx;

        if($page->link == '/'){
            $output['data']['products'] = Product::where(['active' => 1, 'category_id' => 1])->orderBy('price', 'DESC')->limit(4)->with('options')->get();
        } elseif($page->link == '/news' || $page->link == '/info'){
            $output['data']['news'] = Page::where(['id' => $page->id])->orderBy('created_at', 'DESC')->paginate(10);
        } elseif ($page->link == '/shop'){
            $output['data']['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->with('options')->get();
        }

        return $output;
    }
	/**
	 * Build tree pages array with childs
	 * @return array
	 */
	public static function getPagesTree() : array
	{
		$pages = Page::all()->keyBy('id');
		$a = [];

		foreach ($pages as $key => $page) {
			$a[$key] = $page->toArray();
			$a[$key]['childs'] = Page::findPageChildsByArray($key, $pages);

			if ($page->parent_id !== 0) {
				unset($a[$key]);
			}
		}
		return $a;
	}


	/**
	 * Remove all childs of certain page
	 * @param {Int} $id
	 * @return {Boolean}
	 */
	public static function removeChilds(int $id)
	{
		$childs = Page::where('parent_id', $id)->get();
		foreach ($childs as $page) {

			/** Try delete model
			 */
			try {
				$page->delete();
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new \Exception($e->getMessage(), 1);
			}
			Page::removeChilds($page->id);
		}

		return true;
	}
}
