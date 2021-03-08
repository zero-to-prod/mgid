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
        $client             = (new MockServer())->authenticate()->addResponse('{"a":1}')->getClient();
        MgidClient::$client = $client;
        $mgid               = new MgidClient('user', 'secret');
        self::assertEquals(1, $mgid->campaign(1)->get()['a']);
    }
}
