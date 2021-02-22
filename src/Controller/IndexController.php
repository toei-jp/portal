<?php

declare(strict_types=1);

namespace App\Controller;

use App\ORM\Entity;
use Slim\Http\Request;
use Slim\Http\Response;

class IndexController extends GeneralController
{
    public const THEATER_SHIBUYA    = 1;
    public const THEATER_MARUNOUCHI = 2;

    /**
     * index action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeIndex(Request $request, Response $response, array $args): Response
    {
        $mainBanners = $this->getMainBanners();

        $shibuya    = null;
        $marunouchi = null;

        foreach ($this->theaters as $theater) {
            if ($theater->getId() === self::THEATER_SHIBUYA) {
                $shibuya = $theater;
            } elseif ($theater->getId() === self::THEATER_MARUNOUCHI) {
                $marunouchi = $theater;
            }
        }

        $shibuyaTopics = $this->getTopics($shibuya);

        $marunouchiTopics = $this->getTopics($marunouchi);

        $showingSchedules = $this->getShowingSchedules();

        $soonSchedules = $this->getSoonSchedules();

        $campaigns = $this->getCampaigns(self::PAGE_ID);

        return $this->render($response, 'index/index.html.twig', [
            'mainBanners' => $mainBanners,
            'shibuya' => $shibuya,
            'marunouchi' => $marunouchi,
            'shibuyaTopics' => $shibuyaTopics,
            'marunouchiTopics' => $marunouchiTopics,
            'showingSchedules' => $showingSchedules,
            'soonSchedules' => $soonSchedules,
            'campaigns' => $campaigns,
        ]);
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
