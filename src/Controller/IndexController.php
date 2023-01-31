<?php

declare(strict_types=1);

namespace App\Controller;

use App\ORM\Entity;
use Slim\Http\Request;
use Slim\Http\Response;

class IndexController extends GeneralController
{
    public const THEATER_MARUNOUCHI = 2;

    /**
     * index action
     *
     * @param array<string, mixed> $args
     */
    public function executeIndex(Request $request, Response $response, array $args): Response
    {
        $mainBanners = $this->getMainBanners();

        $marunouchi = null;

        foreach ($this->theaters as $theater) {
            if ($theater->getId() === self::THEATER_MARUNOUCHI) {
                $marunouchi = $theater;
            }
        }

        $marunouchiTopics = $this->getTopics($marunouchi);

        $showingSchedules = $this->getShowingSchedules();

        $soonSchedules = $this->getSoonSchedules();

        $campaigns = $this->getCampaigns(self::PAGE_ID);

        return $this->render($response, 'index/index.html.twig', [
            'mainBanners' => $mainBanners,
            'marunouchi' => $marunouchi,
            'marunouchiTopics' => $marunouchiTopics,
            'showingSchedules' => $showingSchedules,
            'soonSchedules' => $soonSchedules,
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * @return Entity\MainBanner[]
     */
    protected function getMainBanners(): array
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
     * @return Entity\News[]
     */
    protected function getTopics(Entity\Theater $theater): array
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findByTheater($theater->getId(), [Entity\News::CATEGORY_TOPICS], 2);
    }

    /**
     * @return Entity\Schedule[]
     */
    protected function getShowingSchedules(): array
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findShowing();
    }

    /**
     * @return Entity\Schedule[]
     */
    protected function getSoonSchedules(): array
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findSoon();
    }

    /**
     * @return Entity\Campaign[]
     */
    protected function getCampaigns(int $pageId): array
    {
        return $this->em
            ->getRepository(Entity\Campaign::class)
            ->findByPage($pageId);
    }
}
