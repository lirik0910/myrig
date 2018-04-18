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

        /*
         * Captcha
         */
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $response = $request->post('g-recaptcha-response');
        $validate = $this->captchaValidate($response, $user_ip);

        if($validate['success'] == false){
            return response()->json(['message' => 'Повторите снова пройти капчу'], 422);
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

    /*
     * Captcha curl
     */
    public function captchaValidate($response, $remoteip)
    {
        $data = [
            'secret' => '6LdY_VMUAAAAAJpD1qJ6R8VxPhCB0_MhUAjBAapa',
            'response' => $response,
            'remoteip' => $remoteip
        ];
        $ch = curl_init();
        $url = "https://www.google.com/recaptcha/api/siteverify";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $reply = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $reply = json_decode($reply, true);

        return $reply;
    }
}
