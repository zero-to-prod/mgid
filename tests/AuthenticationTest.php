<?php

namespace Zerotoprod\Mgid\Tests;

use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\Mgid;

class AuthenticationTest extends TestCase
{
    /** @test */
    public function client_can_login(): void
    {
        $mgid = new Mgid('mcguin57424@gmail.com', 'Aaron333');
        self::assertNotNull($mgid->token);
        self::assertNotNull($mgid->refresh_token);
        self::assertNotNull($mgid->id_auth);
    }
}
