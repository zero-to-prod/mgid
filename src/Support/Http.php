<?php

namespace Zerotoprod\Mgid\Support;

use GuzzleHttp\Client;
use Zerotoprod\Mgid\Support\HttpBase;

class Http
{
    /**
     * @param  string  $url
     *
     * @return HttpBase
     */
    public static function setUrl(string $url): HttpBase
    {
        return (new HttpBase())->setUrl($url);
    }

    /**
     * @param  array  $data
     *
     * @return HttpBase
     */
    public static function setData(array $data): HttpBase
    {
        return (new HttpBase())->setData($data);
    }

    /**
     * @param  Client  $client
     *
     * @return HttpBase
     */
    public static function setClient(Client $client): HttpBase
    {
        return (new HttpBase())->setClient($client);
    }
}
