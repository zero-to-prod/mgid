<?php
/** @noinspection PhpExpressionResultUnusedInspection */

namespace Zerotoprod\Mgid\Tests;

use JsonException;
use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\BaseMgidClient;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;
use Zerotoprod\Mgid\MgidClient;
use Zerotoprod\Mgid\Tests\Mocks\MockServer;

class AuthenticationTest extends TestCase
{
    /**
     * @test
     */
    public function login_successful(): void
    {
        $content = '{"token": 1231111, "refreshToken": 456, "idAuth": 789}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        MgidClient::$client = $client;
        $mgid = new MgidClient('user@domain.com', 'secret');
        self::assertNotNull($mgid->token);
        self::assertNotNull($mgid->refresh_token);
        self::assertNotNull($mgid->id_auth);
    }

    /**
     * @test
     */
    public function malformed_response_missing_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"refresh_token": 123, "id_auth": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        MgidClient::$client = $client;
        new MgidClient('user@domain.com', 'secret');
    }

    /**
     * @test
     */
    public function malformed_response_missing_refresh_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"token": 123, "idAuth": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        MgidClient::$client = $client;
        new MgidClient('user@domain.com', 'secret');
    }

    /**
     * @test
     */
    public function malformed_response_missing_id_auth(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"token": 123, "refreshToken": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        MgidClient::$client = $client;
        new MgidClient('user@domain.com', 'secret');
    }

    /**
     * @test
     */
    public function client_attempts_too_many_times(): void
    {
        $this->expectException(TooManyFailedAttempts::class);
        $content = get_stub('responses/errors/too_many_failed_attempts.json');
        $client  = (new MockServer())->addResponse($content)->getClient();
        MgidClient::$client = $client;
        new MgidClient('user@domain.com', 'secret');
    }
}
