<?php
/** @noinspection PhpExpressionResultUnusedInspection */

namespace Zerotoprod\Mgid\Tests;

use JsonException;
use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\BaseMgidClient;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;
use Zerotoprod\Mgid\Tests\Mocks\MockServer;

class AuthenticationTest extends TestCase
{
    /**
     * @test
     * @throws JsonException|MalformedResponse|TooManyFailedAttempts
     */
    public function login_successful(): void
    {
        $content = '{"token": 123, "refresh_token": 456, "id_auth": 789}';
        $client  = (new MockServer())->addResponse($content)->getClient();

        $mgid = new BaseMgidClient('user', 'secret', $client);
        self::assertEquals('123', $mgid->token);
        self::assertEquals('456', $mgid->refresh_token);
        self::assertEquals('789', $mgid->id_auth);
    }

    /**
     * @test
     * @throws JsonException|MalformedResponse|TooManyFailedAttempts
     */
    public function malformed_response_missing_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"refresh_token": 123, "id_auth": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        new BaseMgidClient('johndoe@domain.com', 'secret', $client);
    }

    /**
     * @test
     * @throws JsonException|MalformedResponse|TooManyFailedAttempts
     */
    public function malformed_response_missing_refresh_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"token": 123, "id_auth": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        new BaseMgidClient('johndoe@domain.com', 'secret', $client);
    }

    /**
     * @test
     * @throws JsonException|MalformedResponse|TooManyFailedAttempts
     */
    public function malformed_response_missing_id_auth(): void
    {
        $this->expectException(MalformedResponse::class);
        $content = '{"token": 123, "refresh_token": 123}';
        $client  = (new MockServer())->addResponse($content)->getClient();
        new BaseMgidClient('johndoe@domain.com', 'secret', $client);
    }

    /**
     * @test
     * @throws JsonException|MalformedResponse|TooManyFailedAttempts
     */
    public function client_attempts_too_many_times(): void
    {
        $this->expectException(TooManyFailedAttempts::class);
        $content = get_stub('responses/errors/too_many_failed_attempts.json');
        $client  = (new MockServer())->addResponse($content)->getClient();
        new BaseMgidClient('johndoe@domain.com', 'secret', $client);
    }
}
