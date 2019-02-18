<?php
/**
 * routes.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

use Toei\Portal\Controller\AboutController;
use Toei\Portal\Controller\IndexController;
use Toei\Portal\Controller\TheaterController;
use Toei\Portal\Controller\ScheduleController;

use Toei\Portal\Controller\API\AuthController as AuthApiController;

/** @var \Slim\App $app */

$app->get('/', IndexController::class . ':index')->setName('homepage');

$app->get('/faq/', AboutController::class . ':faq')->setName('faq');

$app->get('/showing/', ScheduleController::class . ':showing')->setName('schedule_showing');
$app->get('/coming_soon/', ScheduleController::class . ':soon')->setName('schedule_soon');

$app->group('/theaters/{name}/', function () {
    $this->get('', TheaterController::class . ':index')->setName('theater');
    
    $this->group('topics/', function () {
        $this->get('', TheaterController::class . ':topicList')->setName('theater_topic_list');
        $this->get('detail/{id}.php', TheaterController::class . ':topicDetail')->setName('theater_topic_detail');
    });
    
    $this->get('prices/', TheaterController::class . ':price')->setName('theater_price');
    $this->get('advance_tickets/', TheaterController::class . ':advanceTicket')->setName('theater_advance_ticket');
    $this->get('floor_guide/', TheaterController::class . ':floorGuide')->setName('theater_floor_guide');
    $this->get('access/', TheaterController::class . ':access')->setName('theater_access');
});

$app->group('/api', function () {
    $this->group('/auth', function () {
        $this->post('/token', AuthApiController::class . ':token');
    });
});
