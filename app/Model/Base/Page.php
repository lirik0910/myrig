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

	/**
	 * Bind with variable model
	 * @return boolean
	 */
	public function variables()
	{
		return $this->belongsToMany(Variable::class, 'view_variables', 'view_id');
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
}
