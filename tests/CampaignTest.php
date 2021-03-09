<?php

namespace Zerotoprod\Mgid\Tests;

use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\MgidClient;
use Zerotoprod\Mgid\Tests\Mocks\MockServer;

class CampaignTest extends TestCase
{
    /**
     * @test
     */
    public function gets_a_campaign(): void
    {
        MgidClient::$client = MockServer::authenticate()->setResponse('{"a":1}')->getClient();

        $mgid = new MgidClient('user', 'secret');
        self::assertEquals(1, $mgid->campaign(1)->get()['a']);
    }
}
