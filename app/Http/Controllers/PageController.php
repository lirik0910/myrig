<?php

namespace App\Http\Controllers;

use App\Model\Base\Context;
use App\Model\Base\Page;
use App\Model\Base\Setting;
use App\Model\Base\MultiVariableContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
	/**
	 * Get page
	 * @param Request $request
	 * @param (Integer) $number Number of order for success page
	 */
	public function view(Request $request, $number = null)
	{
	    //var_dump($custom_locale); die;
/*	    if($custom_locale){
	        App::setLocale($custom_locale);
        }*/
        $locale = App::getLocale();
//var_dump($locale); die;
		$link = $request->decodedPath();
		$link = $link === '/' ?
			$link :
			rtrim(ltrim($link, '/\\'), '/\\');
		
		if ($number) {
			$link = explode('/' . $number, $link)[0];
		}

		//var_dump($link); die;

		$contexts = Context::all();
		$locale_context_id = 1;

		foreach ($contexts as $context){
		    if(trim(strtolower($context->title)) == $locale){
                $locale_context_id = $context->id;
            }
        }
//var_dump($locale); die;
		if ($page = Page::where('link', $link)->where('context_id', $locale_context_id)->with('view')->first()) {
		    if ($page->link == 'checkout' || $page->link == 'cart'){
		        if(count($this->getInSessionCart()) < 1){
                    return redirect('shop');
                }
            }
//var_dump($page); die;
			return view($page->view->path, [
				'it' => $page,
				'get' => $this->get(),
				'request' => $request,
				'select' => $this->select(),
				'settings' => $this->settings(),
				'inCart' => $this->getInSessionCart(),
				'multi' => MultiVariableContent::multiConvert($page->view->variables),
				'number' => $number,
				'preview' => $this->preview(),
                'locale' => $locale
			]);
		}
		else  abort(404);
	}

	/** 
	 * Get getting page function
	 * @return function
	 */
	public function get()
	{
		return function(int $id) {
			return Page::find($id);
		};
	}

	/** 
	 * Get model select query function
	 * @param function
	 */
	public function select()
	{
		return function($class) {
			return $class::select();
		};
	}

	/**
	 * Get products in cart from session
	 * @return array
	 */
	public function getInSessionCart() : array
	{
		$a = json_decode(session('cart'), true);
		return $a ? $a : [];
	}

	/**
	 * Get settings collection of current context
	 * @return array
	 */
	public function settings() : array
	{
		try {
			$all = Setting::where('context_id', 1)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());

			return [];
		}

		$a = [];
		foreach ($all as $item) {
			$a[$item->title] = $item->value;
		}
		return $a;
	}

	/**
	 * Create preview image
	 * @return function
	 */
	public function preview()
	{
		return function($name = '', $width = 50, $height = 50) {
			$explode = explode('/', $name);
			$file = array_pop($explode);

			$explode = explode('.', $file);
			$extension = array_pop($explode);

			if ($extension === 'svg') {
				return $name;
			}

			$folder = 'preview/'. $width .'x'. $height;
			try {
				Storage::disk('public')->makeDirectory($folder);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return '';
			}

			$dest = 'storage/' . $folder .'/'. md5($name) .'.' .$extension;
			Image::cache(function($image) use ($name, $width, $height, $dest) {
				$image->make($name)->fit($width, $height)->save(public_path($dest));
			});

			return $dest;
		};
	}
}

