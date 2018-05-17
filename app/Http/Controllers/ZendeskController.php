<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Huddle\Zendesk\Facades\Zendesk;
use Illuminate\Http\Request;

class ZendeskController
{
    public function createTicket(Request $request){
        $data = $request->post();
      //  var_dump($data); die;
        //logger($data);
//var_dump($data); die;
        //comment
        try{
            Zendesk::tickets()->create([
                'subject' => $data['subject'],
                'priority' =>'normal',
                'email' => $data['email'],
                'topic' => $data['topic'],
                'description' => $data['message'],
            ]);
        } catch (RequestException $e){
            $requestException = RequestException::create($e->getRequest(), $e->getResponse(), $e);
            return $requestException;
        }

        return response()->json([
            'success' => true
        ], 200);
    }


}