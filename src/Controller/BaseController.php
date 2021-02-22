<?php

declare(strict_types=1);

namespace App\Controller;

use App\ORM\Entity;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class BaseController extends AbstractController
{
    /** @var Entity\Theater[] */
    protected $theaters;

    /**
     * return theaters
     *
     * @return Entity\Theater[]
     */
    private function getTheaters()
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findByActive();
    }

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
        $this->theaters = $this->getTheaters();

        $viewEnvironment = $this->view->getEnvironment();

        // おそらくrender()前に追加する必要があるので、今の仕組み上postExecute()では追加できない。
        $viewEnvironment->addGlobal('theaters', $this->theaters);
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

    /**
     * @param Response $response
     * @param string   $template
     * @param array    $data
     */
    protected function render(Response $response, string $template, array $data = []): Response
    {
        return $this->view->render($response, $template, $data);
    }
}
