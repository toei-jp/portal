<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Controller\AbstractController;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class BaseController extends AbstractController
{
    /**
     * pre execute
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return void
     */
    protected function preExecute(Request $request, Response $response, array $args): void
    {
    }

    /**
     * post execute
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return void
     */
    protected function postExecute(Request $request, Response $response, array $args): void
    {
    }
}
