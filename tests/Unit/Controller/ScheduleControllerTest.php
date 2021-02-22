<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use App\Controller\ScheduleController;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

final class ScheduleControllerTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&ScheduleController
     */
    protected function createTargetMock()
    {
        return Mockery::mock(ScheduleController::class);
    }

    /**
     * @test
     */
    public function testExecuteShowing(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $schedules = ['showing'];
        $targetMock
            ->shouldReceive('getShowingSchedules')
            ->once()
            ->with()
            ->andReturn($schedules);

        $data = ['schedules' => $schedules];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'schedule/showing.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeShowing($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteSoon(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $schedules = ['soon'];
        $targetMock
            ->shouldReceive('getSoonSchedules')
            ->once()
            ->with()
            ->andReturn($schedules);

        $data = ['schedules' => $schedules];
        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'schedule/soon.html.twig', $data)
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeSoon($requestMock, $responseMock, $args)
        );
    }
}
