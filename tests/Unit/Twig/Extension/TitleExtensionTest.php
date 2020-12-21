<?php

/**
 * TitleExtensionTest.php
 */

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use Mockery;
use Toei\Portal\ORM\Entity\Title;
use Toei\Portal\Twig\Extension\TitleExtension;

/**
 * Title extension test
 */
final class TitleExtensionTest extends BaseTestCase
{
    /**
     * Create target mock
     *
     * @return \Mockery\MockInterface|\Mockery\LegacyMockInterface|TitleExtension
     */
    protected function createTargetMock()
    {
        return Mockery::mock(TitleExtension::class);
    }

    /**
     * test getRatingText
     *
     * @test
     *
     * @return void
     */
    public function testGetRatingText()
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();

        $this->assertEquals('G', $targetMock->getRatingText(Title::RATING_G));
        $this->assertEquals('PG12', $targetMock->getRatingText(Title::RATING_PG12));
        $this->assertEquals('R15+', $targetMock->getRatingText(Title::RATING_R15));
        $this->assertEquals('R18+', $targetMock->getRatingText(Title::RATING_R18));
        $this->assertEquals('', $targetMock->getRatingText(0));
    }
}
