<?php
/**
 * BaseController.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

use Toei\Portal\Responder;

/**
 * Base controller
 */
abstract class BaseController extends AbstractController
{
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