<?php

namespace Modules\Delivery\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;

abstract class RemoteApiService
{
    protected Client $client;
    protected array $headers = [];

    /**
     * RemoteApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['verify' => env('GUZZLE_HTTPS_VERIFY', false)]);
    }

    /**
     * @param $url
     * @param array $options
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function get($url, $options = array()): StreamInterface
    {
        if (!empty($options)) {
            $url = $url . $this->prepareOptions($options);
        }

        $res = $this->client->request('GET', $url, [
            'headers' => $this->headers,
        ]);

        return json_decode($res->getBody());
    }

    /**
     * @param array $options
     * @return string
     */
    protected function prepareOptions(array $options): string
    {
        $result = '?';

        foreach ($options as $key => $value) {
            $result .= $key . '=' .$value .'&';
        }

        return rtrim($result, "&");
    }
}
