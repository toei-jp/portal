<?php

declare(strict_types=1);

namespace Tests\Unit\Session;

use App\Session\SessionManager;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\Storage\ArrayStorage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Session\SessionManager
 * @testdox セッションについて管理する SessionManager クラスのテスト
 */
class SessionManagerTest extends TestCase
{
    private function factorySessionManager(): SessionManager
    {
        $sessionManager = new SessionManager(new StandardConfig());
        $sessionManager->setStorage(new ArrayStorage());

        return $sessionManager;
    }

    /**
     * @covers ::getContainer
     * @test
     */
    public function 引数で指定した名前空間を持つコンテナを取得する(): void
    {
        // Arrange
        $sut = $this->factorySessionManager();

        // Act
        $hogeContainer = $sut->getContainer('hoge');

        // Assert
        $this->assertSame('hoge', $hogeContainer->getName());
    }

    /**
     * @covers ::getContainer
     * @test
     */
    public function 名前空間が同じコンテナを複数回取得しても同じコンテナを返す(): void
    {
        // Arrange
        $sut = $this->factorySessionManager();

        // Act
        $first         = $sut->getContainer('hoge');
        $first['hoge'] = 'fuga';
        $second        = $sut->getContainer('hoge');

        // Assert
        $this->assertSame($first, $second);
        $this->assertSame('fuga', $second['hoge']);
    }
}
