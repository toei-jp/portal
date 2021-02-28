<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\ORM\Entity\ShowingFormat;
use App\Twig\Extension\ShowingFormatExtension;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

final class ShowingFormatExtensionTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&ShowingFormatExtension
     */
    protected function createTargetMock()
    {
        return Mockery::mock(ShowingFormatExtension::class);
    }

    /**
     * @test
     */
    public function testGetVoiceText(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();

        $this->assertEquals('字幕版', $targetMock->getVoiceText(ShowingFormat::VOICE_SUBTITLE));
        $this->assertEquals('吹替版', $targetMock->getVoiceText(ShowingFormat::VOICE_DUB));
        $this->assertEquals('', $targetMock->getVoiceText(0));
    }
}
