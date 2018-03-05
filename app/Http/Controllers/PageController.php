<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Base\Page;

class PageController extends Controller
{

    public function view(Request $request){
        $page = new Page;
        $output = $page->getContent($request->getRequestUri());

        return view($output['viewName'], $output['data']);
    }
}
