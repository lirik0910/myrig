<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Model\Shop\Report;
use App\Model\Shop\ReportProduct;

class ReportController extends Controller
{
    /*
     * Create report
     * @return boolean
     */
    public function create(Request $request)
    {
        //return response()->json(['message' => 'gergreg'], 422);
        try {
            $columns = Schema::getColumnListing('reports');
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Try get post data from request object
         */
        try {
            $data = $request->only($columns);
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Create and fill new product model
         */
        $model = new Report;
        $model->fill($data);

        /** Try save product model
         */
        try {
            $model->save();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Add images to product
         */
        if ($request->input('products')) {
            try {
                $model->setProducts($request->input('products'));
            }
            catch (\Exception $e) {
                logger($e->getMessage());
                return response()->json(['message' => $e->getMessage()], 422);
            }
        }

        return response()->json(true, 200);
    }
}
