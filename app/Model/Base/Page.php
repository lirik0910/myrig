<?php

namespace App\Model\Base;

use App\Model\Shop\Product;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Page extends Model
{
	/**
	 * Bind page width context
	 *
	 */
	public function context() {
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page width view
	 *
	 */
	public function view() {
		return $this->belongsTo(View::class);
	}

	public function variables(){
	    return $this->belongsToMany(Variable::class, 'variable_contents')->withPivot('content');
    }

	public function getContent($link){
        $page = $this->where(['link' => $link])->with('view', 'variables')->first();

        if(!$page){
            return view('404');
        }

        $data = [];
        $data['page'] = $page;
        $data['settings'] = Setting::where(['context_id' => $page->context_id])->get();

        if($page->link == '/'){
            $data['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->limit(4)->with('images')->get();
        } elseif($page->link == '/news'){
            $data['news'] = Page::where(['id' => $page->id])->orderBy('created_at', 'DESC')->paginate(10);
        } elseif ($page->link == '/shop'){
            $data['products'] = Product::where(['active' => 1])->orderBy('price', 'DESC')->with('images', 'options')->get();
        }
        return view(explode('.', $page->view->path)[0], $data);
    }
}
