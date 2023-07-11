<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\ShowingFormat;
use App\Twig\Extension\ShowingFormatExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

/**
 * @coversDefaultClass \App\Twig\Extension\ShowingFormatExtension
 * @testdox 上映方式に関するTwig拡張機能
 */
final class ShowingFormatExtensionTest extends TestCase
{
    /**
     * @covers ::getFunctions
     * @dataProvider functionNameDataProvider
     * @test
     */
    public function 決まった名称のtwigヘルパー関数が含まれる(string $name): void
    {
        // Arrange
        $sut = new ShowingFormatExtension();

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
            ['showing_format_voice_text'],
        ];
    }

    /**
     * @covers ::getVoiceText
     * @dataProvider voiceTextDataProvider
     * @test
     */
    public function 音声区分に応じたラベルを取得(int $type, string $expected): void
    {
        // Arrange
        $sut = new ShowingFormatExtension();

        // Act
        $result = $sut->getVoiceText($type);

        // Assert
        $this->assertSame($result, $expected);
    }

    /**
     * @return array<string,array{int,string}>
     */
    public function voiceTextDataProvider(): array
    {
        return [
            '字幕' => [ShowingFormat::VOICE_SUBTITLE, '字幕版'],
            '吹替' => [ShowingFormat::VOICE_DUB, '吹替版'],
            '無効な区分' => [0, ''],
        ];
    }
}
