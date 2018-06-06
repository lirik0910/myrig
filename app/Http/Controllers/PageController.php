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

use App\DbImport as Import;

class PageController extends Controller
{
	/**
	 * Get page
	 * @param Request $request
	 * @param (Integer) $number Number of order for success page
	 */
	public function view(Request $request, $number = null)
	{
		//$import = new Import();
        //$import->process();
        $locale = App::getLocale();

        if(!isset($_SESSION['cart'])){
            $cart = [];
        } else{
            $cart = $_SESSION['cart'];
        }

		$link = $request->decodedPath();
		$link = $link === '/' ?
			$link :
			rtrim(ltrim($link, '/\\'), '/\\');

		if ($number) {
			$link = explode('/' . $number, $link)[0];
		}

		$contexts = Context::all();
		$locale_context_id = 1;

		foreach ($contexts as $context){
		    if(trim(strtolower($context->title)) == $locale){
                $locale_context_id = $context->id;
            }
        }

        $page = Page::where('link', $link)->where('context_id', $locale_context_id)->where('delete', 0)->with('view')->first();

		if ($page) {
		    switch ($page->link){
                case 'checkout':
                    if(count($cart) < 1){
                        return redirect('shop');
                    } elseif (!isset($_SESSION['client'])){
                        return redirect('sso-login');
                    }
                    break;
                case 'cart':
                    if(count($cart) < 1){
                        return redirect('shop');
                    }
                    break;
            }

            if($page->view->title == 'Product' && $page->product->delete == 1){
                return redirect('shop');
            }

			return view($page->view->path, [
				'it' => $page,
				'get' => $this->get(),
				'request' => $request,
				'select' => $this->select(),
				'settings' => $this->settings($locale_context_id),
				'inCart' => $cart,
				'multi' => MultiVariableContent::multiConvert($page->view->variables),
				'number' => $number,
				'preview' => $this->preview(),
                'locale' => $locale
			]);
		} elseif (stristr($link, 'news') || stristr($link, 'info')){
            $page = Page::where('link', $link)->where('delete', 0)->with('view')->first();
            return view($page->view->path, [
                'it' => $page,
                'get' => $this->get(),
                'request' => $request,
                'select' => $this->select(),
                'settings' => $this->settings($locale_context_id),
                'inCart' => $cart,
                'multi' => MultiVariableContent::multiConvert($page->view->variables),
                'number' => $number,
                'preview' => $this->preview(),
                'locale' => $locale
            ]);
        } else  abort(404);
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
	public function settings($context_id) : array
	{
		try {
			$all = Setting::where('context_id', $context_id)->get();
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
			$fileInfo = pathinfo($name);

			/** If standart image extension
			 */
			if ($fileInfo['extension'] !== 'jpg' && $fileInfo['extension'] !== 'jpeg' && $fileInfo['extension'] !== 'png') {
					return $name;
			}

			/** Cached folder
			 */
			$storageDir = 'optimized/'. $width .'x'. $height;
			
			/** Optimazid file name
			 */
			$fileName = md5($name) .'-'. md5($width) .'-'. md5($height) .'.'. $fileInfo['extension'];

			/** Check if current image already exists
			 */
			if (file_exists(public_path('storage/'. $storageDir .'/'. $fileName))) {
				return asset('storage/'. $storageDir .'/'. $fileName);
			}

			/** Try to create folder for current size
			 */
			try {
				Storage::disk('public')->makeDirectory($storageDir);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return $name;
			}

			/** Create instance of new file
			 */
			$image = Image::make(public_path() .'/'. str_replace(asset('/'), '', $name));
			$image->fit($width, $height);

			/** Try render and save new file
			 */
			try {
				$image->save(storage_path('app/public/'. $storageDir .'/') . $fileName, 60);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return $name;
			}

			return asset('storage/'. $storageDir .'/'. $fileName);
		};
	}
}

