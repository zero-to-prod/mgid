<?php

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Zerotoprod\Mgid\ExtendedClasses\GuzzleHttpWrapper;

class HttpBase
{
    private $url;
    private $data = [];
    private Client $client;

    /**
     * @return GuzzleHttpWrapper
     * @throws GuzzleException
     */
    public function post(): GuzzleHttpWrapper
    {
        RequestOptions::FORM_PARAMS;
        $client = $this->client ?? MgidClient::$client;

        return (new GuzzleHttpWrapper())->setResponse($client->request('get', $this->url, ['form_params' => $this->data]));
    }

    /**
     * @return GuzzleHttpWrapper
     * @throws GuzzleException
     */
    public function get(): GuzzleHttpWrapper
    {
        $client = $this->client ?? MgidClient::$client;

        return (new GuzzleHttpWrapper())->setResponse($client->request('get', $this->url, $this->data));
    }

    /**
     * @param  string  $url
     *
     * @return HttpBase
     */
    public function setUrl(string $url): HttpBase
    {
        $this->url = Mgid::$apiBase.$url;

        return $this;
    }

    /**
     * @param  array  $data
     *
     * @return HttpBase
     */
    public function setData(array $data): HttpBase
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  GuzzleHttpWrapper  $client
     *
     * @return HttpBase
     */
    public function setClient(Client $client): HttpBase
    {
        $this->client = $client;

        return $this;
    }
}
