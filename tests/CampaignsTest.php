<?php

namespace Zerotoprod\Mgid\Tests;

use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\MgidClient;
use Zerotoprod\Mgid\Tests\Mocks\MockServer;

class CampaignsTest extends TestCase
{
    /**
     * @test
     */
    public function gets_campaigns(): void
    {
        MgidClient::$client = MockServer::authenticate()->setResponse(get_stub('responses/campaigns.json'))->getClient();

        $mgid = new MgidClient('user@domain.com', 'secret');
        print_r($mgid->campaigns()->get());
        // self::assertEquals(1, $mgid->campaign(1)->get()['a']);
    }
}
