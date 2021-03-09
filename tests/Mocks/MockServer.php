<?php

namespace Zerotoprod\Mgid\Tests\Mocks;

class MockServer
{
    /**
     * @return Server
     */
    public static function authenticate(): Server
    {
        return (new Server())->authenticate();
    }

    /**
     * @param  string  $response
     *
     * @return Server
     */
    public static function setResponse(string $response): Server
    {
        return (new Server())->setResponse($response);
    }
}