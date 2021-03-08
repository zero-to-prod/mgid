<?php

namespace Zerotoprod\Mgid\Helpers;

use JsonException;
use Psr\Http\Message\ResponseInterface;

class ResponseHelper
{
    /**
     * @param  ResponseInterface  $response
     *
     * @return mixed
     * @throws JsonException
     */
    public static function getContents(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}