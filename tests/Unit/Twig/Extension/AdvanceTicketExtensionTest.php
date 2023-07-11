<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\AdvanceTicket;
use App\Twig\Extension\AdvanceTicketExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

/**
 * @coversDefaultClass \App\Twig\Extension\AdvanceTicketExtension
 * @testdox 前売券に関するTwig拡張機能
 */
final class AdvanceTicketExtensionTest extends TestCase
{
    /**
     * @covers ::getFunctions
     * @dataProvider functionNameDataProvider
     * @test
     */
    public function 決まった名称のtwigヘルパー関数が含まれる(string $name): void
    {
        // Arrange
        $sut = new AdvanceTicketExtension();

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
            ['at_type_label'],
            ['at_special_gift_stock_label'],
        ];
    }

    /**
     * @covers ::getTypeLabel
     * @dataProvider typeLabelDataProvider
     * @test
     */
    public function 前売区分に応じたラベルを取得する(int $type, string $expected): void
    {
        // Arrange
        $sut = new AdvanceTicketExtension();

        // Act
        $result = $sut->getTypeLabel($type);

        // Assert
        $this->assertSame($result, $expected);
    }

    /**
     * @return array<string,array{int,string}>
     */
    public function typeLabelDataProvider(): array
    {
        return [
            'ムビチケ' => [AdvanceTicket::TYPE_MVTK, 'ムビチケ'],
            '紙券' => [AdvanceTicket::TYPE_PAPER, '紙券'],
            '無効な区分' => [0, ''],
        ];
    }

    /**
     * @covers ::getSpecialGiftStockLabel
     * @dataProvider specialGiftStockLabelDataProvider
     * @test
     */
    public function 特典在庫区分に応じたラベルを取得(int $type, string $expected): void
    {
        // Arrange
        $sut = new AdvanceTicketExtension();

        // Act
        $result = $sut->getSpecialGiftStockLabel($type);

        // Assert
        $this->assertSame($result, $expected);
    }

    /**
     * @return array<string,array{int,string}>
     */
    public function specialGiftStockLabelDataProvider(): array
    {
        return [
            '有り' => [AdvanceTicket::SPECIAL_GIFT_STOCK_IN, '（有り）'],
            '残り僅か' => [AdvanceTicket::SPECIAL_GIFT_STOCK_FEW, '（残り僅か）'],
            '特典終了' => [AdvanceTicket::SPECIAL_GIFT_STOCK_NOT_IN, '（特典終了）'],
            '無効な区分' => [0, ''],
        ];
    }
}
