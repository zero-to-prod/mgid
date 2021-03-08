<?php
/** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\Mgid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;
use Zerotoprod\Mgid\Helpers\ResponseHelper;

class Campaign
{
    public $token;
    public $refresh_token;
    public $id_auth;
    private Client $client;
    private int $id;

    /**
     * Mgid constructor.
     *
     * @param  int  $id
     * @param  BaseMgidClient  $mgid
     */
    public function __construct(int $id, BaseMgidClient $mgid)
    {
        $this->id   = $id;
        $this->mgid = $mgid;
    }

    /**
     * https://help.mgid.com/api-advertisers#toc5.
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function get()
    {
        $token    = $this->mgid->token;
        $id_auth  = $this->mgid->id_auth;
        $id       = $this->id;
        $response = $this->mgid->client->request(
            'GET',
            Mgid::$apiBase."goodhits/clients/$id_auth/campaigns/$id?token=$token"
        );

        return ResponseHelper::getContents($response);
    }
}
