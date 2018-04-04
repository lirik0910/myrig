<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Shop\Report;
use App\Model\Shop\ReportProducts;

class ReportController extends Controller
{
    /*
     * Create report
     * @return boolean
     */
    public function create()
    {
        return response()->json(true, 200);
    }
}
