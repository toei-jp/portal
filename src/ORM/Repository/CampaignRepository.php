<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\Campaign;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CampaignRepository extends EntityRepository
{
    protected function getActiveQuery(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.isDeleted = false')
            ->andWhere($qb->expr()->andX(
                $qb->expr()->lte('c.startDt', 'CURRENT_TIMESTAMP()'),
                $qb->expr()->gt('c.endDt', 'CURRENT_TIMESTAMP()')
            ));

        return $qb;
    }

    /**
     * @return Campaign[]
     */
    public function findByPage(int $pageId): array
    {
        $qb = $this->getActiveQuery();

        $qb
            ->join('c.pages', 'pc')
            ->andWhere('pc.page = :page_id')
            ->setParameter('page_id', $pageId)
            ->orderBy('pc.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
