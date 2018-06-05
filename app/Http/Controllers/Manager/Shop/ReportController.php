<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 04.04.2018
 * Time: 19:24
 */

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\Report;
use App\Model\Shop\ExchangeRate;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    /**
     * Add conditions before query
     * @param object $c
     * @param array $param
     * @return object
     */
    protected function setParamsBeforeQuery($c, array $params)
    {

        /** Filter by processed
         */
        if (isset($params['status']) && $params['status'] != 0) {
            $status = 0;
            if($params['status'] == 2){
                $status = 1;
            }
            $c = $c->where('check', $status);
        }

        return $c;
    }

    /**
     * Pagination query
     * @param object $c
     * @param array $param
     * @return object
     */
    protected function setPaginationQuery($c, array $params)
    {
        if (isset($params['start']) && isset($params['limit'])) {
            $c = $c->forPage($params['start'], $params['limit']);
        }

        return $c;
    }

    /**
     * Get all reports
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request) : JsonResponse
    {
        /** Try set params to query
         */
        try {
            $all = Report::select();
            $all = $this->setParamsBeforeQuery($all, $request->all());
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Try count all models
         */
        try {
            $total = $all->count();
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Add pagination and get
         */
        try {
            $all = $this->setPaginationQuery($all, $request->all());
            $all = $all->orderBy('id', 'desc')->get();
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        foreach ($all as $report) {
            $report->name;
            $report->email;
            $report->phone;
            $report->check;

            foreach ($report->products as $item) {
                $item->count;
                $item->product;
            }
        }

        return response()->json([
            'total' => $total,
            'data' => $all
        ], 200);
    }

    /**
     * Delete reports
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        /** Try get model
         */
        try {
            $model = Report::find($id);
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Try remove model
         */
        try {
            $model->delete();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => true], 200);
    }

    /**
     * Delete many reports
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMany(Request $request) : JsonResponse
    {
        foreach ($request->all() as $id) {
            $this->delete($id);
        }

        return response()->json(['message' => true], 200);
    }

    /**
     * Get certain report
     * @param int $id Report ID
     * @return JsonResponse
     */
    public function get(int $id) : JsonResponse
    {
        /** Try get model
         */
        try {
            $model = Report::find($id);
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($model, 200);
    }

    /**
     * Update report data
     * @param int $id
     * @param EditReportRequest $request
     * @return JsonResponse
     */
    public function edit(int $id, Request $request) : JsonResponse
    {
        /** Try get model
         */
        try {
            $model = Report::find($id);
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }
//var_dump($model); die;
        /** Try fill new data
         */
        try {
            $model->fill(['check' => 1]);
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Try safe model
         */
        try {
            $model->save();
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($model, 200);
    }
}