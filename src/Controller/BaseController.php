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
     * @return Entity\Theater[]
     */
    private function getTheaters(): array
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findByActive();
    }

    /**
     * pre execute
     *
     * @param array<string, mixed> $args
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
     * @param array<string, mixed> $args
     */
    protected function postExecute(Request $request, Response $response, array $args): void
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(Response $response, string $template, array $data = []): Response
    {
        return $this->view->render($response, $template, $data);
    }
}
