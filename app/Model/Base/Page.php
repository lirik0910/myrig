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
	 * Bind page width context
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page width view
	 * @return boolean
	 */
	public function view()
	{
		return $this->belongsTo(View::class);
	}

	public function variables(){
	    return $this->belongsToMany(Variable::class, 'variable_contents')->withPivot('content');
    }

	public function getContent($link){
        $page = $this->where(['link' => $link])->with('view', 'variables')->first();

        if(!$page){
            return view('content/404');
        }

        $data = [];
        $data['page'] = $page;
        $data['settings'] = Setting::where(['context_id' => $page->context_id])->get();

        if($page->link == '/'){
            $data['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->limit(4)->with('images')->get();
        } elseif($page->link == '/news' || $page->link == '/info'){
            $data['news'] = Page::where(['id' => $page->id])->orderBy('created_at', 'DESC')->paginate(10);
        } elseif ($page->link == '/shop'){
            $data['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->with('images', 'options')->get();
        }
        return view(explode('.', $page->view->path)[0], $data);
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
	 * Find childs of certain page from all pages collaction
	 * @param {Int} $id Current page ID
	 * @param {Collection} $pages Pages colleaction
	 * @return {Array}
	 */
	public static function findPageChildsByArray(int $id, Collection $pages) : array
	{
		$array = [];
		foreach ($pages as $page) {
			if ($page->parent_id == $id) {
				unset($pages[$page->id]);
				$array[$page->id] = $page->toArray();
				$array[$page->id]['childs'] = Page::findPageChildsByArray($page->id, $pages);
			}
		}
		return $array;
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
