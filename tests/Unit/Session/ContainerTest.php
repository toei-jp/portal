<?php

declare(strict_types=1);

namespace Tests\Unit\Session;

use App\Session\Container;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\ArrayStorage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Session\Container
 * @testdox セッションデータを操作するためAPIを提供する Container クラスのテスト
 */
class ContainerTest extends TestCase
{
    private function factorySessionManager(): SessionManager
    {
        $sessionManager = new SessionManager(new StandardConfig());
        $sessionManager->setStorage(new ArrayStorage());

        return $sessionManager;
    }

    private function factoryContainer(string $name): Container
    {
        return new Container($name, $this->factorySessionManager());
    }

    /**
     * @covers ::clear
     * @test
     */
    public function コンテナに保存された値をクリアする(): void
    {
        // Arrange
        $sut         = $this->factoryContainer('testing');
        $sut['hoge'] = 'fuga';

        // Act
        $sut->clear();

        // Assert
        $this->assertNull($sut['hoge']);
    }

    /**
     * @covers ::clear
     * @test
     */
    public function 他の名前空間のコンテナはクリアされない(): void
    {
        // Arrange
        $sutHoge = $this->factoryContainer('hoge');

        $sutFuga         = $this->factoryContainer('fuga');
        $sutFuga['fuga'] = 777;

        // Act
        $sutHoge->clear();

        // Assert
        $this->assertSame(777, $sutFuga['fuga']);
    }
}
