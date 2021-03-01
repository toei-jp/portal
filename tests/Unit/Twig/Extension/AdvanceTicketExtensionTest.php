<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\AdvanceTicket;
use App\Twig\Extension\AdvanceTicketExtension;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

final class AdvanceTicketExtensionTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&AdvanceTicketExtension
     */
    protected function createTargetMock()
    {
        return Mockery::mock(AdvanceTicketExtension::class);
    }

    /**
     * @test
     */
    public function testGetTypeLabel(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();

        $this->assertEquals('ムビチケ', $targetMock->getTypeLabel(AdvanceTicket::TYPE_MVTK));
        $this->assertEquals('紙券', $targetMock->getTypeLabel(AdvanceTicket::TYPE_PAPER));
        $this->assertEquals('', $targetMock->getTypeLabel(0));
    }

    /**
     * @test
     */
    public function testGetSpecialGiftStockLabel(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();

        $this->assertStringContainsString(
            '有り',
            $targetMock->getSpecialGiftStockLabel(AdvanceTicket::SPECIAL_GIFT_STOCK_IN)
        );
        $this->assertStringContainsString(
            '残り僅か',
            $targetMock->getSpecialGiftStockLabel(AdvanceTicket::SPECIAL_GIFT_STOCK_FEW)
        );
        $this->assertStringContainsString(
            '特典終了',
            $targetMock->getSpecialGiftStockLabel(AdvanceTicket::SPECIAL_GIFT_STOCK_NOT_IN)
        );
        $this->assertEquals(
            '',
            $targetMock->getSpecialGiftStockLabel(0)
        );
    }
}
