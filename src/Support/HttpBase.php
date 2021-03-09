<?php

namespace Zerotoprod\Mgid\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Zerotoprod\Mgid\BaseClient;
use Zerotoprod\Mgid\Mgid;
use Zerotoprod\Mgid\MgidClient;

class HttpBase
{
    private $url;
    private $data = [];
    private MgidClient $client;

    /**
     * @return \Zerotoprod\Mgid\Support\GuzzleHttpWrapper
     * @throws GuzzleException
     */
    public function post(): GuzzleHttpWrapper
    {
        RequestOptions::FORM_PARAMS;
        $client = $this->client ?? MgidClient::$client;

        return (new GuzzleHttpWrapper())->setResponse($client->request('post', $this->url, ['form_params' => $this->data]));
    }

    /**
     * @return \Zerotoprod\Mgid\Support\GuzzleHttpWrapper
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
        $this->url = MgidClient::$apiBase.$url;

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
     * @param  \Zerotoprod\Mgid\Support\GuzzleHttpWrapper  $client
     *
     * @return HttpBase
     */
    public function setClient(MgidClient $client): HttpBase
    {
        $this->client = $client;

        return $this;
    }
}
