<?php

namespace App\Services;

use GuzzleHttp\Client;

class KonfiApp
{
    protected $token = '';

    /** @var Client|null  */
    protected $client = null;

    public function __construct($token)
    {
        $this->token = $token;
        $this->client = new Client();
    }

    protected function getOptions($data) {
        $options = [
            'headers' => [
                'accept' => '*/*',
                'X-Konfiapp-Token' => $this->token,
            ],
        ];
        if ($data) $options['query'] = $data;
        return $options;
    }

    protected function get($url, $data = null) {
        $response = $this->client->get('https://api.konfiapp.de/v2'.$url, $this->getOptions($data));
        if (!$response->getStatusCode() == 200) return null;
        $body = json_decode($response->getBody()->getContents(), true);
        if (!$body['status'] == 'ok') return null;
        return $body['data'];
    }

    public function groups()
    {
        return $this->get('/groups') ?? [];
    }
}
