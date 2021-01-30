<?php

namespace App\Controller;

use App\ORM\Entity;
use App\Responder;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Base controller
 */
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
    protected function preExecute($request, $response, $args): void
    {
        $this->theaters = $this->getTheaters();
        $this->data->set('theaters', $this->theaters);
    }

    /**
     * post execute
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return void
     */
    protected function postExecute($request, $response, $args): void
    {
    }

    /**
     * get responder
     *
     * @return Responder\AbstractResponder
     */
    protected function getResponder(): Responder\AbstractResponder
    {
        $path = explode('\\', static::class);
        $name = str_replace('Controller', '', array_pop($path));

        return Responder\BaseResponder::factory($name, $this->view);
    }
}
