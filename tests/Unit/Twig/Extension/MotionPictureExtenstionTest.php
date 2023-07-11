<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\Twig\Extension\MotionPictureExtenstion;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

/**
 * @coversDefaultClass \App\Twig\Extension\MotionPictureExtenstion
 * @testdox モーションピクチャーのサービスに関するTwig拡張機能
 */
final class MotionPictureExtenstionTest extends TestCase
{
    /**
     * @param array<string, string> $params
     */
    private function factoryMotionPictureExtenstion(array $params = []): MotionPictureExtenstion
    {
        $params['api_endpoint']      ??= 'https://example.com';
        $params['waiter_server_url'] ??= 'https://example.com';
        $params['ticket_site_url']   ??= 'https://example.com';
        $params['project_id']        ??= 'hogefuga';

        return new MotionPictureExtenstion($params);
    }

    /**
     * @covers ::getFunctions
     * @dataProvider functionNameDataProvider
     * @test
     */
    public function 決まった名称のtwigヘルパー関数が含まれる(string $name): void
    {
        // Arrange
        $sut = $this->factoryMotionPictureExtenstion();

        // Act
        $functions = $sut->getFunctions();

        // Assert
        $functionNames = [];

        foreach ($functions as $function) {
            $this->assertInstanceOf(TwigFunction::class, $function);
            $functionNames[] = $function->getName();
        }

        $this->assertContains($name, $functionNames);
    }

    /**
     * @return array<array{string}>
     */
    public function functionNameDataProvider(): array
    {
        return [
            ['mp_api_endpoint'],
            ['mp_waiter_server_url'],
            ['mp_ticket_site_url'],
            ['mp_project_id'],
        ];
    }

    /**
     * @covers ::getApiEndpoint
     * @test
     */
    public function APIエンドポイントを取得(): void
    {
        // Arrange
        $sut = $this->factoryMotionPictureExtenstion(['api_endpoint' => 'https://api.example.com']);

        // Act
        $result = $sut->getApiEndpoint();

        // Assert
        $this->assertSame('https://api.example.com', $result);
    }

    /**
     * @covers ::getWaiterServerUrl
     * @test
     */
    public function WaiterサーバーのURLを取得(): void
    {
        // Arrange
        $sut = $this->factoryMotionPictureExtenstion(['waiter_server_url' => 'https://waiter.example.com']);

        // Act
        $result = $sut->getWaiterServerUrl();

        // Assert
        $this->assertSame('https://waiter.example.com', $result);
    }

    /**
     * @covers ::getTicketSiteUrl
     * @test
     */
    public function チケットサイトのURLを取得(): void
    {
        // Arrange
        $sut = $this->factoryMotionPictureExtenstion(['ticket_site_url' => 'https://ticket.example.com']);

        // Act
        $result = $sut->getTicketSiteUrl();

        // Assert
        $this->assertSame('https://ticket.example.com', $result);
    }

    /**
     * @covers ::getProjectId
     * @test
     */
    public function プロジェクトIDを取得(): void
    {
        // Arrange
        $sut = $this->factoryMotionPictureExtenstion(['project_id' => 'foo_project']);

        // Act
        $result = $sut->getProjectId();

        // Assert
        $this->assertSame('foo_project', $result);
    }
}
