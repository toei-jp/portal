<?php

declare(strict_types=1);

namespace Tests\Unit\Controller;

use App\Controller\BaseController;
use App\ORM\Entity\Theater;
use App\ORM\Repository\TheaterRepository;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use ReflectionClass;
use Slim\Container;
use Twig\Environment;

final class BaseControllerTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&BaseController
     */
    protected function createTargetMock(Container $container)
    {
        return Mockery::mock(BaseController::class, [$container]);
    }

    protected function createTargetReflection(): ReflectionClass
    {
        return new ReflectionClass(BaseController::class);
    }

    /**
     * @test
     */
    public function testGetTheaters(): void
    {
        $container = $this->createContainer();

        $theaters = [];

        $repositoryMock = $this->createTheaterRepositoryMock();
        $repositoryMock
            ->shouldReceive('findByActive')
            ->once()
            ->with()
            ->andReturn($theaters);

        $entityMangerMock = $this->createEntityManagerMock();
        $entityMangerMock
            ->shouldReceive('getRepository')
            ->once()
            ->with(Theater::class)
            ->andReturn($repositoryMock);

        $container['em'] = $entityMangerMock;

        $targetMock = $this->createTargetMock($container);

        $targetRef = $this->createTargetReflection();

        $getTheatersMethodRef = $targetRef->getMethod('getTheaters');
        $getTheatersMethodRef->setAccessible(true);

        $this->assertEquals(
            $theaters,
            $getTheatersMethodRef->invoke($targetMock)
        );
    }

    /**
     * @return MockInterface&LegacyMockInterface&TheaterRepository
     */
    protected function createTheaterRepositoryMock()
    {
        return Mockery::mock(TheaterRepository::class);
    }

    /**
     * @test
     */
    public function testPreExecute(): void
    {
        $container = $this->createContainer();

        $theaters = ['theater'];

        // getTheaters()がprivateでモックできないので、中身をモックする
        $repositoryMock = $this->createTheaterRepositoryMock();
        $repositoryMock
            ->shouldReceive('findByActive')
            ->once()
            ->with()
            ->andReturn($theaters);

        $entityMangerMock = $this->createEntityManagerMock();
        $entityMangerMock
            ->shouldReceive('getRepository')
            ->once()
            ->with(Theater::class)
            ->andReturn($repositoryMock);

        $container['em'] = $entityMangerMock;

        $viewEnvMock = $this->createViewEnvironmentMock();
        $viewEnvMock
            ->shouldReceive('addGlobal')
            ->once()
            ->with('theaters', $theaters);

        $viewMock = $this->createViewMock();
        $viewMock
            ->shouldReceive('getEnvironment')
            ->once()
            ->with()
            ->andReturn($viewEnvMock);

        $container['view'] = $viewMock;

        $targetMock = $this->createTargetMock($container);

        $targetRef = $this->createTargetReflection();

        $reqestMock   = $this->createRequestMock();
        $responseMock = $this->createResponseMock();
        $args         = [];

        $preExecuteMethodRef = $targetRef->getMethod('preExecute');
        $preExecuteMethodRef->setAccessible(true);
        $preExecuteMethodRef->invoke($targetMock, $reqestMock, $responseMock, $args);

        $theatersPropertyRef = $targetRef->getProperty('theaters');
        $theatersPropertyRef->setAccessible(true);

        $this->assertEquals(
            $theaters,
            $theatersPropertyRef->getValue($targetMock)
        );
    }

    /**
     * @return MockInterface&LegacyMockInterface&Environment
     */
    protected function createViewEnvironmentMock()
    {
        return Mockery::mock(Environment::class);
    }

    /**
     * @test
     */
    public function testRender(): void
    {
        $container = $this->createContainer();

        $responseMock = $this->createResponseMock();
        $template     = 'test.html.twig';
        $data         = ['test' => 'abc'];

        $viewMock = $this->createViewMock();
        $viewMock
            ->shouldReceive('render')
            ->once()
            ->with($responseMock, $template, $data)
            ->andReturn($responseMock);

        $container['view'] = $viewMock;

        $targetMock = $this->createTargetMock($container);

        $targetRef = $this->createTargetReflection();

        $renderMethodRef = $targetRef->getMethod('render');
        $renderMethodRef->setAccessible(true);

        $this->assertEquals(
            $responseMock,
            $renderMethodRef->invoke($targetMock, $responseMock, $template, $data)
        );
    }
}
