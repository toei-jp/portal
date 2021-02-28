<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\MainBanner;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class MainBannerRepository extends EntityRepository
{
    protected function getActiveQuery(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('mb');
        $qb
            ->where('mb.isDeleted = false');

        return $qb;
    }

    /**
     * @return MainBanner[]
     */
    public function findByPageId(int $pageId): array
    {
        $qb = $this->getActiveQuery();
        $qb
            ->join('mb.pages', 'pmb')
            ->andWhere('pmb.page = :page_id')
            ->setParameter('page_id', $pageId)
            ->orderBy('pmb.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return MainBanner[]
     */
    public function findByTheaterId(int $theaterId): array
    {
        $qb = $this->getActiveQuery();
        $qb
            ->join('mb.theaters', 'tmb')
            ->andWhere('tmb.theater = :theater_id')
            ->setParameter('theater_id', $theaterId)
            ->orderBy('tmb.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
