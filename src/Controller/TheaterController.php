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
        $this->data->set('mainBanners', $this->getMainBanners($this->theater));
        
        $this->data->set('topics', $this->getTopics($this->theater));
    }
    
    /**
     * return main_banners
     *
     * @param Entity\Theater $theater
     * @return Entity\MainBanner[]
     */
    protected function getMainBanners(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\MainBanner::class)
            ->findByTheaterId($theater->getId());
    }
    
    /**
     * return topics
     * 
     * @param Entity\Theater $theater
     * @return Entity\News[]
     */
    protected function getTopics(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findByTheater($theater->getId(), [ Entity\News::CATEGORY_TOPICS ], 3);
    }
}
