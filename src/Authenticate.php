<?php

namespace Zerotoprod\Mgid;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;
use Zerotoprod\Mgid\Helpers\ResponseHelper;

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
        $response_contents = ResponseHelper::getContents($response);
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
            throw new TooManyFailedAttempts('Too many failed attempts.');
        }

        return $response_contents;
    }

    /**
     * @param $response_contents
     *
     * @throws MalformedResponse
     */
    private function throwExceptionOnMalformedResponse($response_contents): void
    {
        $validator  = Validation::createValidator();
        $constraint = new Assert\Collection(
            [
                'token'         => new Assert\NotBlank(),
                'refresh_token' => new Assert\NotBlank(),
                'id_auth'       => new Assert\NotBlank(),
            ]
        );

        if (count($violations = $validator->validate($response_contents, $constraint)) > 0) {
            throw new MalformedResponse($violations[0]->getMessage());
        }
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