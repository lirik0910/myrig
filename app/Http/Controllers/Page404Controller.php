<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Base\Context;
use App\Model\Base\Page;
use App\Model\Base\Setting;
use App\Model\Base\MultiVariableContent;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\DbImport as Import;

class Page404Controller extends PageController
{
    public function notFound(Request $request, $number = null)
    {
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
        }

        else {
            $page = Page::whereHas('view', function ($q) {
                $q->where('title', '404');
            })->first();
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
        }
    }
}
