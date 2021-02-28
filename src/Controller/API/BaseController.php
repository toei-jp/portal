<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Controller\AbstractController;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class BaseController extends AbstractController
{
    /**
     * @param array<string, mixed> $args
     */
    protected function preExecute(Request $request, Response $response, array $args): void
    {
    }

    /**
     * @param array<string, mixed> $args
     */
    protected function postExecute(Request $request, Response $response, array $args): void
    {
    }
}
