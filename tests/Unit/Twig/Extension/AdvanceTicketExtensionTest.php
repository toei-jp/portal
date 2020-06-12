<?php

/**
 * AdvanceTicketExtensionTest.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use Mockery;
use Toei\Portal\ORM\Entity\AdvanceTicket;
use Toei\Portal\Twig\Extension\AdvanceTicketExtension;

/**
 * AdvanceTicket extension test
 */
final class AdvanceTicketExtensionTest extends BaseTestCase
{
    /**
     * Create target mock
     *
     * @return \Mockery\MockInterface|\Mockery\LegacyMockInterface|AdvanceTicketExtension
     */
    protected function createTargetMock()
    {
        return Mockery::mock(AdvanceTicketExtension::class);
    }

    /**
     * test getTypeLabel
     *
     * @test
     * @return void
     */
    public function testGetTypeLabel()
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();

        $this->assertEquals('ムビチケ', $targetMock->getTypeLabel(AdvanceTicket::TYPE_MVTK));
        $this->assertEquals('紙券', $targetMock->getTypeLabel(AdvanceTicket::TYPE_PAPER));
        $this->assertEquals('', $targetMock->getTypeLabel(0));
    }

    /**
     * test getSpecialGiftStockLabel
     *
     * @test
     * @return void
     */
    public function testGetSpecialGiftStockLabel()
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
