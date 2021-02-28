<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\Twig\Extension\MotionPictureExtenstion;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use ReflectionClass;

final class MotionPictureExtenstionTest extends BaseTestCase
{
    /**
     * @return MockInterface&LegacyMockInterface&MotionPictureExtenstion
     */
    protected function createTargetMock()
    {
        return Mockery::mock(MotionPictureExtenstion::class);
    }

    protected function createTargetReflection(): ReflectionClass
    {
        return new ReflectionClass(MotionPictureExtenstion::class);
    }

    /**
     * @test
     */
    public function testConstruct(): void
    {
        $targetMock = $this->createTargetMock();
        $settings   = ['foo' => 'bar'];

        // execute constructor
        $targetRef      = $this->createTargetReflection();
        $constructorRef = $targetRef->getConstructor();
        $constructorRef->invoke($targetMock, $settings);

        // test property "settings"
        $settingsPropertyRef = $targetRef->getProperty('settings');
        $settingsPropertyRef->setAccessible(true);
        $this->assertEquals(
            $settings,
            $settingsPropertyRef->getValue($targetMock)
        );
    }

    /**
     * @test
     */
    public function testGetApiEndpoint(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();
        $settings = ['api_endpoint' => 'example.com/api'];

        $targetRef           = $this->createTargetReflection();
        $settingsPropertyRef = $targetRef->getProperty('settings');
        $settingsPropertyRef->setAccessible(true);
        $settingsPropertyRef->setValue($targetMock, $settings);

        $this->assertEquals($settings['api_endpoint'], $targetMock->getApiEndpoint());
    }

    /**
     * @test
     */
    public function testGetWaiterServerUrl(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();
        $settings = ['waiter_server_url' => 'https://example.com/waiter'];

        $targetRef = $this->createTargetReflection();

        $settingsPropertyRef = $targetRef->getProperty('settings');
        $settingsPropertyRef->setAccessible(true);
        $settingsPropertyRef->setValue($targetMock, $settings);

        $this->assertEquals($settings['waiter_server_url'], $targetMock->getWaiterServerUrl());
    }

    /**
     * @test
     */
    public function testGetTicketSiteUrl(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();
        $settings = ['ticket_site_url' => 'https://example.com/ticket'];

        $targetRef = $this->createTargetReflection();

        $settingsPropertyRef = $targetRef->getProperty('settings');
        $settingsPropertyRef->setAccessible(true);
        $settingsPropertyRef->setValue($targetMock, $settings);

        $this->assertEquals($settings['ticket_site_url'], $targetMock->getTicketSiteUrl());
    }

    /**
     * @test
     */
    public function testGetProjectId(): void
    {
        $targetMock = $this->createTargetMock();
        $targetMock->makePartial();
        $settings = ['project_id' => 'aaabbbccc'];

        $targetRef = $this->createTargetReflection();

        $settingsPropertyRef = $targetRef->getProperty('settings');
        $settingsPropertyRef->setAccessible(true);
        $settingsPropertyRef->setValue($targetMock, $settings);

        $this->assertEquals($settings['project_id'], $targetMock->getProjectId());
    }
}
