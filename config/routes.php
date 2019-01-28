<?php
/**
 * routes.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

use Toei\Portal\Controller\IndexController;
use Toei\Portal\Controller\TheaterController;

$app->get('/', IndexController::class . ':index')->setName('homepage');

$app->group('/theaters/{name}', function () {
    $this->get('/', TheaterController::class . ':index')->setName('theater');
});
