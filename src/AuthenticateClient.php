<?php

namespace Zerotoprod\Mgid;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class AuthenticateClient
{
    public string $token;
    public string $refresh_token;
    public string $id_auth;

    /**
     * Authenticate constructor.
     *
     * @param  string  $email
     * @param  string  $password
     *
     * @throws MalformedResponse
     * @throws TooManyFailedAttempts|JsonException|GuzzleException
     */
    public function __construct(string $email, string $password)
    {
        $response = Http::setUrl('auth/token')
            ->setData(['email' => $email, 'password' => $password])->post()->asArray();
        $this->throwExceptionOnTooManyFailedAttempts($response);
        $this->throwExceptionOnMalformedResponse($response);
        $this->assignPropertiesFromResponse($response);
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
                'token'        => new Assert\NotBlank(),
                'refreshToken' => new Assert\NotBlank(),
                'idAuth'       => new Assert\NotBlank(),
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
        $this->refresh_token = $response_contents['refreshToken'];
        $this->id_auth       = $response_contents['idAuth'];
    }
}