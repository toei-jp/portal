<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use App\Controller\AboutController;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

final class AboutControllerTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&AboutController
     */
    protected function createTargetMock()
    {
        return Mockery::mock(AboutController::class);
    }

    /**
     * @test
     */
    public function testExecuteFaq(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'about/faq.html.twig')
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeFaq($requestMock, $responseMock, $args)
        );
    }

    /**
     * @test
     */
    public function testExecuteLaw(): void
    {
        $requestMock  = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $targetMock = $this->createTargetMock();
        $targetMock
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $targetMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, 'about/law.html.twig')
            ->andReturn($responseMock);

        $this->assertEquals(
            $responseMock,
            $targetMock->executeLaw($requestMock, $responseMock, $args)
        );
    }
}
