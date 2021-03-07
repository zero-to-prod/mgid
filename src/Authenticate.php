<?php

namespace Zerotoprod\Mgid;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class Authenticate
{
    public string $token;
    public string $refresh_token;
    public string $id_auth;

    /**
     * Authenticate constructor.
     *
     * @param  string  $email
     * @param  string  $password
     * @param $client
     *
     * @throws MalformedResponse
     * @throws TooManyFailedAttempts|JsonException
     */
    public function __construct(string $email, string $password, $client)
    {
        $response          = $client->request(
            'POST',
            Mgid::$apiBase.'auth/token',
            [
                'email'    => $email,
                'password' => $password,
            ]
        );
        $response_contents = $this->getResponseContents($response);
        $this->throwExceptionOnTooManyFailedAttempts($response_contents);
        $this->throwExceptionOnMalformedResponse($response_contents);
        $this->assignPropertiesFromResponse($response_contents);
    }

    /**
     * @param $response_contents
     *
     * @return mixed
     * @throws TooManyFailedAttempts
     */
    private function throwExceptionOnTooManyFailedAttempts(array $response_contents): array
    {
        if (isset($response_contents['errors'])) {
            throw new TooManyFailedAttempts('Too many failed attempts');
        }

        return $response_contents;
    }

    /**
     * @param  ResponseInterface  $response
     *
     * @return mixed
     * @throws JsonException
     */
    private function getResponseContents(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $response_contents
     *
     * @throws MalformedResponse
     */
    private function throwExceptionOnMalformedResponse($response_contents): void
    {
        if (isset($response_contents['token'], $response_contents['refresh_token'], $response_contents['id_auth'])) {
            return;
        }
        throw new MalformedResponse("Malformed response.");
    }

    /**
     * @param $response_contents
     */
    private function assignPropertiesFromResponse($response_contents): void
    {
        $this->token         = $response_contents['token'];
        $this->refresh_token = $response_contents['refresh_token'];
        $this->id_auth       = $response_contents['id_auth'];
    }
}