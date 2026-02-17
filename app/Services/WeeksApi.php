<?php

namespace App\Services;

class WeeksApi
{
    public static function get($path = '')
    {
        $config = [];

        if (config('sdclient.ssl_verify_peer') === 'no') {
            $config = ['curl' => [CURLOPT_SSL_VERIFYPEER => false]];
        }

        $client = new \GuzzleHttp\Client($config);

        $response = $client->request('GET', weeks_api_url($path), [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return collect(json_decode((string) $response->getBody(), true));
    }
}
