<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

class BaseMgidClient
{
    public $token;
    public $refresh_token;
    public $id_auth;

    public function campaign(int $id)
    {
        return new Campaign($id, $this);
    }
}
