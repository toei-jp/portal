<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\Schedule;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ScheduleRepository extends EntityRepository
{
    protected function getActiveQuery(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.isDeleted = false')
            ->andWhere('s.publicStartDt <= CURRENT_TIMESTAMP()')
            ->andWhere('s.publicEndDt > CURRENT_TIMESTAMP()');

        return $qb;
    }

    protected function getShowingQuery(): QueryBuilder
    {
        $qb = $this->getActiveQuery();

        $qb
            ->andWhere('s.startDate <= CURRENT_DATE()')
            ->orderBy('s.startDate', 'DESC');

        return $qb;
    }

    /**
     * @return Schedule[]
     */
    public function findShowing(): array
    {
        $qb = $this->getShowingQuery();

        return $qb->getQuery()->getResult();
    }

    protected function getSoonQuery(): QueryBuilder
    {
        $qb = $this->getActiveQuery();

        $qb
            ->andWhere('s.startDate > CURRENT_DATE()')
            ->orderBy('s.startDate', 'ASC');

        return $qb;
    }

    /**
     * @return Schedule[]
     */
    public function findSoon(): array
    {
        $qb = $this->getSoonQuery();

        return $qb->getQuery()->getResult();
    }
}
