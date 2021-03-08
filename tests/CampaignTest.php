<?php

namespace Zerotoprod\Mgid\Tests;

use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\BaseMgidClient;
use Zerotoprod\Mgid\Tests\Mocks\MockServer;

class CampaignTest extends TestCase
{
    /**
     * @test
     */
    public function gets_a_campaign(): void
    {
        $client = (new MockServer())->authenticate()->addResponse('{"a":1}')->getClient();
        $mgid   = new BaseMgidClient('user', 'secret', $client);
        self::assertEquals(1, $mgid->campaign(1)->get()['a']);
    }
}
