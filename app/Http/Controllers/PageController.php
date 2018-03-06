<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Base\Page;

class PageController extends Controller
{

    public function view(Request $request){
        //var_dump($request->session()); die;
        $page = new Page;
        $output = $page->getContent($request);
//var_dump($output['data']['products']); die;
        return view($output['viewName'], $output['data']);
    }
}
