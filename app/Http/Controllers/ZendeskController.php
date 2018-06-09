<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Huddle\Zendesk\Facades\Zendesk;
use Illuminate\Http\Request;
use Validator;

class ZendeskController
{
    public function createTicket(Request $request){
        $data = $request->post();

        try{
            Zendesk::tickets()->create([
                'subject' => $data['subject'],
                'priority' =>'normal',
                'email' => $data['email'],
                'topic' => $data['topic'],
                'description' => $data['message'],
                'requester' => array('locale_id' => '1', 'name' => $data['email'], 'email' => $data['email']),
                'image' => $data['file']
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