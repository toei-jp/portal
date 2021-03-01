<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use App\Controller\IndexController;
use App\ORM\Entity\Theater;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use ReflectionClass;

final class IndexControllerTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&IndexController
     */
    protected function createTargetMock()
    {
        return Mockery::mock(IndexController::class);
    }

    protected function createTargetReflection(): ReflectionClass
    {
        return new ReflectionClass(IndexController::class);
    }

    /**
     * @test
     */
    public function testExecuteIndex(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mainBanners = ['mainBanners'];
        $targetMock
            ->shouldReceive('getMainBanners')
            ->once()
            ->with()
            ->andReturn($mainBanners);

        $theaterShibuyaMock = $this->createTheaterMock();
        $theaterShibuyaMock
            ->shouldReceive('getId')
            ->with()
            ->andReturn(1);

        $theaterMarunouchiMock = $this->createTheaterMock();
        $theaterMarunouchiMock
            ->shouldReceive('getId')
            ->with()
            ->andReturn(2);

        $shibuyaTopics = ['shibuyaTopics'];
        $targetMock
            ->shouldReceive('getTopics')
            ->once()
            ->with($theaterShibuyaMock)
            ->andReturn($shibuyaTopics);

        $marunouchiTopics = ['marunouchiTopics'];
        $targetMock
            ->shouldReceive('getTopics')
            ->once()
            ->with($theaterMarunouchiMock)
            ->andReturn($marunouchiTopics);

        $showingSchedules = ['showingSchedules'];
        $targetMock
            ->shouldReceive('getShowingSchedules')
            ->once()
            ->with()
            ->andReturn($showingSchedules);

        $soonSchedules = ['soonSchedules'];
        $targetMock
            ->shouldReceive('getSoonSchedules')
            ->once()
            ->with()
            ->andReturn($soonSchedules);

        $campaigns = ['campaigns'];
        $targetMock
            ->shouldReceive('getCampaigns')
            ->once()
            ->with(1)
            ->andReturn($campaigns);

        $targetRef = $this->createTargetReflection();

        $theatersPropertyRef = $targetRef->getProperty('theaters');
        $theatersPropertyRef->setAccessible(true);
        $theatersPropertyRef->setValue($targetMock, [$theaterShibuyaMock, $theaterMarunouchiMock]);

        $data = [
            'mainBanners' => $mainBanners,
            'shibuya' => $theaterShibuyaMock,
            'marunouchi' => $theaterMarunouchiMock,
            'shibuyaTopics' => $shibuyaTopics,
            'marunouchiTopics' => $marunouchiTopics,
            'showingSchedules' => $showingSchedules,
            'soonSchedules' => $soonSchedules,
            'campaigns' => $campaigns,
        ];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'index/index.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeIndex($requestMock, $responseMock, $args)
        );
    }

    /**
     * @return MockInterface&LegacyMockInterface&Theater
     */
    protected function createTheaterMock()
    {
        return Mockery::mock(Theater::class);
    }
}
