<?php

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;

class Mgid
{
    public $token;
    public $refresh_token;
    public $id_auth;

    /**
     * Mgid constructor.
     *
     * @param  string  $email
     * @param  string  $password
     */
    public function __construct(string $email, string $password)
    {
        $this->authenticate($email, $password);
    }

    /**
     * @param  string  $email
     * @param  string  $password
     */
    private function authenticate(string $email, string $password): void
    {
        $client = new Client();
        $response = $client->request(
            'POST',
            'http://api.mgid.com/v1/auth/token',
            [
                'email' => $email,
                'password' => $password,
            ]
        );
        //{"errors":["[TOO_MANY_FAILED_ATTEMPTS_METHOD_TEMPORARILY_LOCKED]"]}
        print_r($response->getBody()->getContents());
        // if (isset($response->getBody()['token'])) {
        //     print_r($response);
        // }

        // return false;
        // // todo Implement authentication.
        // $this->token         = 'token';
        // $this->refresh_token = 'refresh_token';
        // $this->id_auth       = 'id_auth';
    }
}
