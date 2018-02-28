<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Base\Page;

class PageController extends Controller
{

    public function view(Request $request){
        $page = new Page;
        //var_dump($request->path()); die;
        return $page->getContent($request->getRequestUri());//view($view->title);
    }
}
