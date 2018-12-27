<?php
/**
 * routes.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

use Toei\Portal\Controller\IndexController;


$app->get('/', IndexController::class . ':index')->setName('homepage');
