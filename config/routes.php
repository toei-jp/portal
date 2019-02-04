<?php
/**
 * routes.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

use Toei\Portal\Controller\IndexController;
use Toei\Portal\Controller\TheaterController;
use Toei\Portal\Controller\ScheduleController;

use Toei\Portal\Controller\API\AuthController as AuthApiController;

/** @var \Slim\App $app */

$app->get('/', IndexController::class . ':index')->setName('homepage');

$app->get('/showing/', ScheduleController::class . ':showing')->setName('schedule_showing');
$app->get('/coming_soon/', ScheduleController::class . ':soon')->setName('schedule_soon');

$app->group('/theaters/{name}/', function () {
    $this->get('', TheaterController::class . ':index')->setName('theater');
});

$app->group('/api', function() {
    $this->group('/auth', function() {
        $this->post('/token', AuthApiController::class . ':token');
    });
});
