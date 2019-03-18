<?php
/**
 * BaseController.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

use Toei\Portal\ORM\Entity;
use Toei\Portal\Responder;

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
     * @param int $id
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
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
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
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
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
        $path = explode('\\', get_class($this));
        $container = str_replace('Controller', '', array_pop($path));
        $responder = Responder::class . '\\' . $container . 'Responder';
        
        return new $responder($this->view);
    }
}
