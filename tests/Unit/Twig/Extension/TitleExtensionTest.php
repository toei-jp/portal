<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\Title;
use App\Twig\Extension\TitleExtension;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

final class TitleExtensionTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&TitleExtension
     */
    protected function createTargetMock()
    {
        return Mockery::mock(TitleExtension::class);
    }

    /**
     * @test
     */
    public function testGetRatingText(): void
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
