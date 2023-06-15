<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization;

use App\Authorization\Cache;
use App\Authorization\Token\ClientCredentialsToken;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Tests\Unit\Authorization\Token\TestAccessToken;

/**
 * @covers \App\Authorization\Cache
 * @testdox 認可に関するキャッシュを扱うクラスのテスト
 */
class CacheTest extends TestCase
{
    private function factoryCache(): Cache
    {
        return new Cache(new ArrayAdapter());
    }

    private function factoryToken(string $token = 'foo_token'): ClientCredentialsToken
    {
        return ClientCredentialsToken::create(new TestAccessToken(
            $token,
            'foo_type',
            time() + 3600
        ));
    }

    /**
     * @covers ::getToken
     * @test
     */
    public function キャッシュにトークンが保存されていない場合、nullを返す(): void
    {
        // Arrange
        $sut = $this->factoryCache();

        // Act
        $result = $sut->getToken();

        // Assert
        $this->assertNull($result);
    }

    /**
     * @covers ::getToken
     * @covers ::saveToken
     * @test
     */
    public function キャッシュにトークンが保存されている場合、トークンを返す(): void
    {
        // Arrange
        $sut = $this->factoryCache();

        // Act
        $sut->saveToken($this->factoryToken('hogefuga'));
        $result = $sut->getToken();

        // Assert
        $this->assertSame('hogefuga', $result->getAccessToken());
    }

    /**
     * @covers ::getToken
     * @covers ::saveToken
     * @test
     */
    public function キャッシュの有効期限を超えている場合は、nullを返す(): void
    {
        // Arrange
        $sut        = $this->factoryCache();
        $expiration = (new DateTimeImmutable())->setTimestamp(time());

        // Act
        $sut->saveToken($this->factoryToken('hogefuga'), $expiration);
        sleep(2);
        $result = $sut->getToken();

        // Assert
        $this->assertNull($result);
    }
}
