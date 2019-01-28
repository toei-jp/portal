<?php
/**
 * TheaterController.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Slim\Exception\NotFoundException;

use Toei\Portal\ORM\Entity;

/**
 * Theater controller
 */
class TheaterController extends BaseController
{
    /**@var Entity\Theater $theater */
    protected $theater;
    
    /**
     * find by entity
     *
     * @param string $name
     * @return Entity\Theater|null
     */
    protected function getTheater(string $name)
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findOneByName($name);
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
        if (!isset($args['name']) || empty($args['name'])) {
            throw new NotFoundException($request, $response);
        }
        
        $theaterName = $args['name'];
        $this->theater = $this->getTheater($theaterName);
        
        if (is_null($this->theater)) {
            throw new NotFoundException($request, $response);
        }
        
        $this->data->set('theater', $this->theater);
        
        parent::preExecute($request, $response, $args);
    }
    
    /**
     * index action
     * 
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeIndex($request, $response, $args)
    {
    }
}
