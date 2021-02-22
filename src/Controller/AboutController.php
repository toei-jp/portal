<?php

declare(strict_types=1);

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AboutController extends GeneralController
{
    /**
     * faq action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeFaq(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'about/faq.html.twig');
    }

    /**
     * law action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeLaw(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'about/law.html.twig');
    }
}
