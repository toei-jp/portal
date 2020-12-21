<?php

/**
 * IndexController.php
 */

namespace Toei\Portal\Controller;

use Toei\Portal\ORM\Entity;

/**
 * Index controller
 */
class IndexController extends GeneralController
{
    public const THEATER_SHIBUYA    = 1;
    public const THEATER_MARUNOUCHI = 2;

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

        $shibuya    = null;
        $marunouchi = null;

        foreach ($this->theaters as $theater) {
            /** @var Entity\Theater $theater */

            if ($theater->getId() === self::THEATER_SHIBUYA) {
                /** @var Entity\Theater $shibuya */
                $shibuya = $theater;
            } elseif ($theater->getId() === self::THEATER_MARUNOUCHI) {
                /** @var Entity\Theater $marunouchi */
                $marunouchi = $theater;
            }
        }

        $this->data->set('shibuya', $shibuya);
        $this->data->set('marunouchi', $marunouchi);

        $this->data->set('shibuyaTopics', $this->getTopics($shibuya));
        $this->data->set('marunouchiTopics', $this->getTopics($marunouchi));

        $this->data->set('showingSchedules', $this->getShowingSchedules());

        $this->data->set('soonSchedules', $this->getSoonSchedules());

        $this->data->set('campaigns', $this->getCampaigns(self::PAGE_ID));
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
     * return topics
     *
     * 劇場に設定されたものを取得する TOEI-137
     *
     * @link https://m-p.backlog.jp/view/TOEI-137
     *
     * @param Entity\Theater $theater
     * @return Entity\News[]
     */
    protected function getTopics(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findByTheater($theater->getId(), [Entity\News::CATEGORY_TOPICS], 2);
    }

    /**
     * return showing schedules
     *
     * @return Entity\Schedule[]
     */
    protected function getShowingSchedules()
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findShowing();
    }

    /**
     * return soon schedules
     *
     * @return Entity\Schedule[]
     */
    protected function getSoonSchedules()
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findSoon();
    }

    /**
     * return campaigns
     *
     * @param int $pageId
     * @return Entity\Campaign[]
     */
    protected function getCampaigns(int $pageId)
    {
        return $this->em
            ->getRepository(Entity\Campaign::class)
            ->findByPage($pageId);
    }
}
