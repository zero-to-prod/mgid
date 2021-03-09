<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Zerotoprod\Mgid\Support\Http;

class Campaigns
{
    public $token;
    public $refresh_token;
    public $id_auth;

    /**
     * Mgid constructor.
     *
     * @param  BaseClient  $mgid
     */
    public function __construct(BaseClient $mgid)
    {
        $this->mgid = $mgid;
    }

    /**
     * https://help.mgid.com/api-advertisers#toc5.
     *
     * @throws GuzzleException|JsonException
     */
    public function get()
    {
        $token    = $this->mgid->token;
        $id_auth  = $this->mgid->id_auth;

        return Http::setUrl("goodhits/clients/$id_auth/campaigns?token=$token")->get()->bodyContentsAsArray();
    }
}
