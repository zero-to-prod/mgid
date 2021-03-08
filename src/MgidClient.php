<?php

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;
use JsonException;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class MgidClient extends BaseMgidClient
{
    /**
     * Mgid constructor.
     *
     * @param  string  $email
     * @param  string  $password
     *
     * @throws MalformedResponse
     * @throws TooManyFailedAttempts
     * @throws JsonException
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct($email, $password);
    }
}
