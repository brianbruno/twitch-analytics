<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 16/03/2019
 * Time: 22:35
 */

namespace App\Helpers;

use GuzzleHttp\Client;

class Requisicao {

    public function get($url) {

        $twitchID = env('TWITCH_CLIENTID');
        $client = new Client();
        $headers = ['headers' => [
            'Origin' => 'http://brian.place',
            'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
            "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            'Client-ID' => $twitchID ]
        ];

        $response = $client->request('GET', $url, $headers);

        $response = json_decode($response->getBody()->getContents());

        return $response;
    }
}