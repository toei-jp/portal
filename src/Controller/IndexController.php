<?php
/**
 * IndexController.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Toei\Portal\ORM\Entity;

/**
 * Index controller
 */
class IndexController extends GeneralController
{
    const THEATER_SHIBUYA = 1;
    const THEATER_MARUNOUCHI = 2;
    
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
        $this->data->set('mainBanners', $this->getMainBanners());
        
        $this->data->set('shibuya', $this->getTheater(self::THEATER_SHIBUYA));
        $this->data->set('marunouchi', $this->getTheater(self::THEATER_MARUNOUCHI));
    }
    
    /**
     * return main_banners
     *
     * @return Entity\MainBanner[]
     */
    protected function getMainBanners()
    {
        return $this->em
            ->getRepository(Entity\MainBanner::class)
            ->findByPageId(self::PAGE_ID);
    }
    
    /**
     * return theater
     *
     * @param int $id
     * @return Entity\Theater|null
     */
    protected function getTheater(int $id)
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findOneById($id);
    }
}