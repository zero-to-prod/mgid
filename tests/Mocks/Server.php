<?php

namespace Zerotoprod\Mgid\Tests\Mocks;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class Server
{
    private array $queue;
    private bool $authenticate = false;

    /**
     * @param  array  $responses
     *
     * @return Client
     */
    public function responseQueue(array $responses): Client
    {
        return new Client(['handler' => HandlerStack::create(new MockHandler($responses))]);
    }

    /**
     * @return $this
     */
    public function authenticate(): Server
    {
        $this->authenticate = true;

        return $this;
    }

    /**
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     *
     * @return Server
     */
    public function setResponse(string $content, int $status = 200, array $headers = []): Server
    {
        $this->queue[] = response($content, $status, $headers);

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if ($this->authenticate) {
            $this->queue = $this->addAuthenticatedResponseToQueue($this->queue);
        }

        return $this->responseQueue($this->queue);
    }

    /**
     * @param  array  $queue
     *
     * @return array
     */
    private function addAuthenticatedResponseToQueue(array $queue): array
    {
        $content = get_stub('responses/authenticated.json');

        return array_merge([response($content)], $queue);
    }
}