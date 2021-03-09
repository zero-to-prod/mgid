<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid\Support;

use GuzzleHttp\Client;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpWrapper extends Client
{
    public ResponseInterface $response;

    /**
     * @return mixed
     * @throws JsonException
     */
    public function bodyContentsAsArray()
    {
        return json_decode($this->response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return string
     */
    public function bodyContents(): string
    {
        return $this->response->getBody()->getContents();
    }


    /**
     * @param  mixed  $response
     *
     * @return GuzzleHttpWrapper
     */
    public function setResponse(ResponseInterface $response): GuzzleHttpWrapper
    {
        $this->response = $response;

        return $this;
    }
}
