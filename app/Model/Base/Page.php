<?php

namespace App\Model\Base;

use http\Env\Request;
use App\Model\Shop\Product;
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
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page with view
	 * @return boolean
	 */
	public function view()
	{
		return $this->belongsTo(View::class);
	}

<<<<<<< HEAD
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

	public function getContent($request){
        $uri = $request->getRequestUri();
        $link = explode('?', $uri)[0];

        $page = $this->where(['link' => $link])->with('view', 'variables', 'multivariables')->first();

        if(!$page){
            return view('content/404');
        }

        $output = [];
        $output['viewName'] = explode('.', $page->view->path)[0];
        $output['data']['page'] = $page;
        $output['data']['settings'] = Setting::where(['context_id' => $page->context_id])->get();

        if(isset($page->multivariables) && !empty($page->multivariables)){
            $output['data']['migx'] = $this->convertMVs($page->multivariables);
        }

        if($page->parent_id){
            $output['data']['links']['prev'] = Page::select('link')->where('parent_id', $page->parent_id)->where('id', '<', $page->id)->orderBy('id', 'DESC')->limit(1)->get();
            $output['data']['links']['next'] = Page::select('link')->where('parent_id', $page->parent_id)->where('id', '>', $page->id)->orderBy('id', 'ASC')->limit(1)->get();
            $output['data']['links']['parent'] = Page::select('link')->where('id', $page->parent_id)->get();
        } else{
            if($page->link == '/'){
                $output['data']['products'] = Product::where(['active' => 1, 'category_id' => 1])->orderBy('price', 'DESC')->limit(4)->with('options')->get();
            } elseif($page->link == '/news' || $page->link == '/info'){
                $page_limit = 2;
                $page_no = $request->get('page');
                if(isset($page_no)){
                    $output['data']['news'] = Page::where(['parent_id' => $page->id])->offset($page_limit * ($page_no - 1))->orderBy('created_at', 'DESC')->paginate($page_limit);
                } else{
                    $output['data']['news'] = Page::where(['parent_id' => $page->id])->orderBy('created_at', 'DESC')->paginate($page_limit);
                }
            } elseif ($page->link == '/shop'){
                $output['data']['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->with('options')->get();
            }
        }


        return $output;
    }

    /*
     * Convert multivariables collection object to array
     * @param (Object) $mvs Multivariables object
     * @return array
     */
    public function convertMVs($mvs){
        $migx = [];
        foreach ($mvs as $mv){
            $migx[$mv->title][$mv->pivot->content_id][$mv->pivot->name] = $mv->pivot->content;
        }
        return $migx;
    }

=======
>>>>>>> befa162a1115654b00a00035e77947ffb676775a
	/**
	 * Bind with Variable and Variable multi content model
	 * @return boolean
	 */
	public function multivariables()
	{
		return $this->belongsToMany(Variable::class, 'variable_multi_contents')->withPivot('name', 'content', 'content_id');
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
