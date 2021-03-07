<?php
/** @noinspection PhpExpressionResultUnusedInspection */

namespace Zerotoprod\Mgid\Tests;

use JsonException;
use PHPUnit\Framework\TestCase;
use Zerotoprod\Mgid\MgidClient;
use Zerotoprod\Mgid\Exception\MalformedResponse;
use Zerotoprod\Mgid\Exception\TooManyFailedAttempts;

class AuthenticationTest extends TestCase
{
    /**
     * @test
     */
    public function login_successful(): void
    {
        $client = TestHelper::request('{"token": 123, "refresh_token": 456, "id_auth": 789}');
        $mgid   = new MgidClient('johndoe@domain.com', 'secret', $client);
        self::assertEquals('123', $mgid->token);
        self::assertEquals('456', $mgid->refresh_token);
        self::assertEquals('789', $mgid->id_auth);
    }

    /**
     * @test
     */
    public function malformed_response_missing_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $client = TestHelper::request('{"refresh_token": 123, "id_auth": 123}');
        new MgidClient('johndoe@domain.com', 'secret', $client);
    }

    /**
     * @test
     */
    public function malformed_response_missing_refresh_token(): void
    {
        $this->expectException(MalformedResponse::class);
        $client = TestHelper::request('{"token": 123, "id_auth": 123}');
        new MgidClient('johndoe@domain.com', 'secret', $client);
    }

    /**
     * @test
     */
    public function malformed_response_missing_id_auth(): void
    {
        $this->expectException(MalformedResponse::class);
        $client = TestHelper::request('{"token": 123, "refresh_token": 123}');
        new MgidClient('johndoe@domain.com', 'secret', $client);
    }

    /** @test
     * @throws JsonException|MalformedResponse
     */
    public function client_attempts_too_many_times(): void
    {
        $this->expectException(TooManyFailedAttempts::class);
        $client = TestHelper::request(TestHelper::responseError('too_many_failed_attempts.json'));
        new MgidClient('johndoe@domain.com', 'secret', $client);
    }
}
