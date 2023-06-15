<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Token;

use App\Authorization\Token\ClientCredentialsToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers App\Authorization\Token\ClientCredentialsToken
 * @testdox Client Credentials Grant のトークンを示すクラスのテスト
 */
class ClientCredentialsTokenTest extends TestCase
{
    /**
     * @param array<string, mixed> $params
     */
    private function factoryAccessToken(array $params = []): AccessTokenInterface
    {
        // phpcs:disable Generic.Files.LineLength.TooLong
        $defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        // phpcs:enable

        return new TestAccessToken(
            $params['token'] ?? $defaultAccessToken,
            $params['token_type'] ?? 'foo_type',
            $params['expires'] ?? time() + 3600
        );
    }

    /**
     * @covers ::create
     * @test
     */
    public function クラスオブジェクトを生成する(): void
    {
        // Arrange

        // phpcs:disable Generic.Files.LineLength.TooLong
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        // phpcs:enable

        $expires = time() + 3600;

        $accessToken = $this->factoryAccessToken([
            'token' => $token,
            'token_type' => 'example_type',
            'expires' => $expires,
        ]);

        // Act
        $sut = ClientCredentialsToken::create($accessToken);

        // Assert
        $this->assertSame($token, $sut->getAccessToken());
        $this->assertSame('example_type', $sut->getTokenType());
        $this->assertSame($expires, $sut->getExpires());
    }

    /**
     * @covers ::isExpired
     * @dataProvider expiredDataProvider
     * @test
     */
    public function 期限切れの場合、isExpiredメソッドはtrueを返す(int $time): void
    {
        // Arrange
        $accessToken = $this->factoryAccessToken(['expires' => 3600]);
        $sut         = ClientCredentialsToken::create($accessToken);

        // Act
        $result = $sut->isExpired($time);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @return array<string, array{int}>
     */
    public function expiredDataProvider(): array
    {
        return [
            '境界値' => [3601],
            '代表値' => [3660],
        ];
    }

    /**
     * @covers ::isExpired
     * @dataProvider notExpiredDataProvider
     * @test
     */
    public function 期限切れではない場合、isExpiredメソッドはfalseを返す(int $time): void
    {
        // Arrange
        $accessToken = $this->factoryAccessToken(['expires_in' => 3600]);
        $sut         = ClientCredentialsToken::create($accessToken);

        // Act
        $result = $sut->isExpired($time);

        // Assert
        $this->assertFalse($result);
    }

    /**
     * @return array<string, array{int}>
     */
    public function notExpiredDataProvider(): array
    {
        return [
            '境界値' => [3600],
            '代表値' => [3540],
        ];
    }
}
