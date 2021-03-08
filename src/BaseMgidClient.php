<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class BaseMgidClient
{
    public $token;
    public $refresh_token;
    public $id_auth;
    public Client $client;

    /**
     * Mgid constructor.
     *
     * @param  string  $email
     * @param  string  $password
     * @param  Client|null  $client // Used for testing.
     *
     * @throws JsonException
     * @throws MalformedResponse
     * @throws TooManyFailedAttempts
     */
    public function __construct(string $email, string $password, Client $client = null)
    {
        $this->client = $client ?? new Client();
        $response = new Authenticate($email, $password, $this->client);

        $this->token         = $response->token;
        $this->refresh_token = $response->refresh_token;
        $this->id_auth       = $response->id_auth;
    }

    public function campaign(int $id, Client $client = null)
    {
        return new Campaign($id, $this, $client);
    }
}
