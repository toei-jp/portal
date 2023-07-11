<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\Title;
use App\Twig\Extension\TitleExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

/**
 * @coversDefaultClass \App\Twig\Extension\TitleExtension
 * @testdox 作品に関するTwig拡張機能
 */
final class TitleExtensionTest extends TestCase
{
    /**
     * @covers ::getFunctions
     * @dataProvider functionNameDataProvider
     * @test
     */
    public function 決まった名称のtwigヘルパー関数が含まれる(string $name): void
    {
        // Arrange
        $sut = new TitleExtension();

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
            ['title_rating_text'],
        ];
    }

    /**
     * @covers ::getRatingText
     * @dataProvider ratingTextDataProvider
     * @test
     */
    public function レーティング区分に応じたラベルを取得(int $type, string $expected): void
    {
        // Arrange
        $sut = new TitleExtension();

        // Act
        $result = $sut->getRatingText($type);

        // Assert
        $this->assertSame($result, $expected);
    }

    /**
     * @return array<string,array{int,string}>
     */
    public function ratingTextDataProvider(): array
    {
        return [
            'G' => [Title::RATING_G, 'G'],
            'PG12' => [Title::RATING_PG12, 'PG12'],
            'R15+' => [Title::RATING_R15, 'R15+'],
            'R18+' => [Title::RATING_R18, 'R18+'],
            '無効な区分' => [0, ''],
        ];
    }
}
