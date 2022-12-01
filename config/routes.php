<?php

declare(strict_types=1);

use App\Controller\AboutController;
use App\Controller\API\AuthController as AuthApiController;
use App\Controller\IndexController;
use App\Controller\ScheduleController;
use App\Controller\TheaterController;
use Slim\App as SlimApp;

// phpcs:disable SlevomatCodingStandard.Commenting.InlineDocCommentDeclaration
/** @var SlimApp $app */
// phpcs:enable

$app->get('/', IndexController::class . ':index')->setName('homepage');

$app->get('/faq/', AboutController::class . ':faq')->setName('faq');
$app->get('/business_deal/', AboutController::class . ':law')->setName('law');

$app->get('/showing/', ScheduleController::class . ':showing')->setName('schedule_showing');
$app->get('/coming_soon/', ScheduleController::class . ':soon')->setName('schedule_soon');

$app->redirect('/theaters/shibuya/[{path:.*}]', '/notice/shibuya-close.html');

$app->group('/theaters/{name}/', function (): void {
    $this->get('', TheaterController::class . ':index')->setName('theater');

    $this->group('topics/', function (): void {
        $this->get('', TheaterController::class . ':topicList')->setName('theater_topic_list');
        $this->get('detail/{id}.php', TheaterController::class . ':topicDetail')->setName('theater_topic_detail');
    });

    $this->get('prices/', TheaterController::class . ':price')->setName('theater_price');
    $this->get('advance_tickets/', TheaterController::class . ':advanceTicket')->setName('theater_advance_ticket');
    $this->get('floor_guide/', TheaterController::class . ':floorGuide')->setName('theater_floor_guide');
    $this->get('access/', TheaterController::class . ':access')->setName('theater_access');
});

$app->group('/api', function (): void {
    $this->group('/auth', function (): void {
        $this->post('/token', AuthApiController::class . ':token');
    });
});
