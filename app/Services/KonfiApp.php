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
        if ($data) $options['form_params'] = $data;
        return $options;
    }

    protected function request($method, $url, $data = null) {
        $response = $this->client->request($method,'https://api.konfiapp.de/v2'.$url, $this->getOptions($data));
        if (!$response->getStatusCode() == 200) return null;
        $body = json_decode($response->getBody()->getContents(), true);
        if (!$body['status'] == 'ok') return null;
        return $body['data'];

    }

    protected function get($url, $data = null) {
        return $this->request('GET', $url, $data);
    }

    protected function post($url, $data = null) {
        return $this->request('POST', $url, $data);
    }

    public function groups()
    {
        return $this->get('/groups') ?? [];
    }

    public function groupMembers($groupId)
    {
        return $this->get('/groups/members/?id='.$groupId);
    }

    public function createParent($parent)
    {
        unset($parent['mail']);
        return $this->post('/parents/', $parent);
    }

    public function findParent($parent) {
        $parents = $this->get('/parents/');
        foreach ($parents as $thisParent) {
            if (($thisParent['first_name'] == $parent['vorname'])
                && ($thisParent['last_name'] == $parent['nachname'])
                && ($thisParent['phone'] == $parent['phone'])
                && ($thisParent['username'] == $parent['mail'])
            ) {
                $parent['id'] = $thisParent['id'];
                return $parent;
            }
        }
        return null;
    }

    public function createKonfi($record)
    {
        return $this->post('/konfi/', $record);
    }
}
