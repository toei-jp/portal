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
        
        $theaters = $this->getTheaters();
        $this->data->set('theaters', $theaters);
        
        $shibuya = null;
        $marunouchi = null;
        
        foreach ($theaters as $theater) {
            /** @var Entity\Theater $theater */
            
            if ($theater->getId() === self::THEATER_SHIBUYA) {
                /** @var Entity\Theater $shibuya */
                $shibuya = $theater;
            } else if ($theater->getId() === self::THEATER_MARUNOUCHI) {
                /** @var Entity\Theater $marunouchi */
                $marunouchi = $theater;
            }
            
        }
        
        $this->data->set('shibuya', $shibuya);
        $this->data->set('marunouchi', $marunouchi);
        
        $this->data->set('shibuyaTopics', $this->getTopics($shibuya));
        $this->data->set('marunouchiTopics', $this->getTopics($marunouchi));
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
     * return theaters
     *
     * @param int $id
     * @return Entity\Theater[]
     */
    protected function getTheaters()
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findByActive();
    }
    
    /**
     * return topics
     * 
     * 劇場に設定されたものを取得する TOEI-137
     *
     * @param Entity\Theater $theater
     * @return Entity\News[]
     * @link https://m-p.backlog.jp/view/TOEI-137
     */
    protected function getTopics(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findByTheater($theater->getId(), [ Entity\News::CATEGORY_TOPICS ], 2);
    }
}