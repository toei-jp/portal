<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use App\Controller\TheaterController;
use App\ORM\Entity\News;
use App\ORM\Entity\Theater;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use ReflectionClass;
use Slim\Exception\NotFoundException;

final class TheaterControllerTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&TheaterController
     */
    protected function createTargetMock()
    {
        return Mockery::mock(TheaterController::class);
    }

    protected function createTargetReflection(): ReflectionClass
    {
        return new ReflectionClass(TheaterController::class);
    }

    /**
     * @return MockInterface&LegacyMockInterface&Theater
     */
    protected function createTheaterMock()
    {
        return Mockery::mock(Theater::class);
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

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $mainBanners = ['mainBanner'];
        $targetMock
            ->shouldReceive('getMainBanners')
            ->once()
            ->with($theater)
            ->andReturn($mainBanners);

        $topics = ['topic'];
        $targetMock
            ->shouldReceive('getTopics')
            ->once()
            ->with($theater, Mockery::type('int'))
            ->andReturn($topics);

        $data = [
            'theater' => $theater,
            'mainBanners' => $mainBanners,
            'topics' => $topics,
        ];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/index.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeIndex($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteTopicList(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $topics = ['topic'];
        $targetMock
            ->shouldReceive('getTopics')
            ->once()
            ->with($theater)
            ->andReturn($topics);

        $data = [
            'theater' => $theater,
            'topics' => $topics,
        ];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/topic/list.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeTopicList($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteTopicDetail(): void
    {
        $id = 2;

        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = ['id' => $id];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $topic = $this->createNewsMock();
        $targetMock
            ->shouldReceive('getTopic')
            ->once()
            ->with($id)
            ->andReturn($topic);

        $data = [
            'theater' => $theater,
            'news' => $topic,
        ];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/topic/detail.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeTopicDetail($requestMock, $responseMock, $args)
        );
    }

    /**
     * @return MockInterface&LegacyMockInterface&News
     */
    protected function createNewsMock()
    {
        return Mockery::mock(News::class);
    }

    /**
     * @test
     */
    public function testExecuteTopicDetailNotFound(): void
    {
        $id = 99;

        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = ['id' => $id];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $targetMock
            ->shouldReceive('getTopic')
            ->once()
            ->andReturn(null);

        $this->expectException(NotFoundException::class);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeTopicDetail($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteAdvanceTicket(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $advanceTicketList = ['ticket'];
        $targetMock
            ->shouldReceive('getAdvanceTicketList')
            ->once()
            ->with($theater)
            ->andReturn($advanceTicketList);

        $data = [
            'theater' => $theater,
            'advanceTicketList' => $advanceTicketList,
        ];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/advance_ticket/index.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeAdvanceTicket($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecutePrice(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/price/index.html.twig', Mockery::type('array'))
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executePrice($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteFloorGuide(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/floor_guide/index.html.twig', Mockery::type('array'))
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeFloorGuide($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteAccess(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $theater = $this->createTheaterMock();

        $targetRef = $this->createTargetReflection();

        $theaterPropertyRef = $targetRef->getProperty('theater');
        $theaterPropertyRef->setAccessible(true);
        $theaterPropertyRef->setValue($targetMock, $theater);

        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'theater/access/index.html.twig', Mockery::type('array'))
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeAccess($requestMock, $responseMock, $args)
        );
    }
}
