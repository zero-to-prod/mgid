<?php
/** @noinspection PhpIncludeInspection */

namespace Zerotoprod\Mgid\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestHelper
{
    /**
     * @param  string  $body
     *
     * @param  int  $status
     * @param  array  $headers
     *
     * @return Client
     */
    public static function request(string $body = '', int $status = 200, array $headers = []): Client
    {
        $mock = new MockHandler([new Response($status, $headers, $body)]);

        return new Client(['handler' => HandlerStack::create($mock)]);
    }

    /**
     * @param  string  $path
     *
     * @return string
     */
    public static function responseError(string $path):string
    {
        return self::response('errors/'.$path);
    }

    /**
     * @param  string  $path
     *
     * @return string
     */
    public static function response(string $path):string
    {
        return file_get_contents(__DIR__ . '/responses/'.$path);
    }
}
