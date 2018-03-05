<?php

namespace App\Http\Controllers;

use Zendesk\API\HttpClient as ZendeskAPI;
use Illuminate\Http\Request;

class ZendeskController
{
    private $subdomain = "bitmain";
    private $username = "k.tymofieiev@myrig.com";
    private $token = "wpAaZZV7N2MqeM85FtelNiwgllxwBpmfYATjHl2Z";

    public function createTicket(Request $request){
        $client = new ZendeskAPI($this->subdomain);
        //var_dump($client); die;
        $client->setAuth('basic', ['username' => $this->username, 'token' => $this->token]);

        $data = $request->post();
        var_dump($data); die;
    }


}