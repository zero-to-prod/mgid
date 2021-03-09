<?php

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Zerotoprod\Mgid\Auth\AuthenticateClient;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class MgidClient extends BaseClient
{
    public static string $apiBase = 'http://api.mgid.com/v1/';

    /**
     * Mgid constructor.
     *
     * @param  string  $email
     * @param  string  $password
     *
     * @throws MalformedResponse
     * @throws TooManyFailedAttempts
     * @throws JsonException|GuzzleException
     */
    public function __construct(string $email, string $password)
    {
        $this->setClient();

        $authenticated_client = new AuthenticateClient($email, $password);

        $this->assignPropertiesFromAuthenticatedClient($authenticated_client);
    }

    private function setClient(): void
    {
        self::$client = self::$client ?? new Client();
    }

    /**
     * @param  AuthenticateClient  $response
     */
    private function assignPropertiesFromAuthenticatedClient(AuthenticateClient $response): void
    {
        $this->token         = $response->token;
        $this->refresh_token = $response->refresh_token;
        $this->id_auth       = $response->id_auth;
    }
}
