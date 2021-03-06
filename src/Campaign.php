<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Zerotoprod\Mgid\Support\Http;

class Campaign
{
    public $token;
    public $refresh_token;
    public $id_auth;
    private int $id;

    /**
     * Mgid constructor.
     *
     * @param  int  $id
     * @param  BaseClient  $mgid
     */
    public function __construct(int $id, BaseClient $mgid)
    {
        $this->id   = $id;
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
        $id       = $this->id;

        return Http::setUrl("goodhits/clients/$id_auth/campaigns/$id?token=$token")->get()->bodyContentsAsArray();
    }
}
