<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;

class BaseClient
{
    public static Client $client;
    public $token;
    public $refresh_token;
    public $id_auth;

    public function campaign(int $id)
    {
        return new Campaign($id, $this);
    }

    public function campaigns()
    {
        return new Campaigns($this);
    }
}
