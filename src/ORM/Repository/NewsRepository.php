<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\News;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class NewsRepository extends EntityRepository
{
    protected function getActiveQuery(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('n');
        $qb
            ->where('n.isDeleted = false')
            ->andWhere($qb->expr()->andX(
                $qb->expr()->lte('n.startDt', 'CURRENT_TIMESTAMP()'),
                $qb->expr()->gt('n.endDt', 'CURRENT_TIMESTAMP()')
            ));

        return $qb;
    }

    public function findOneById(int $id): ?News
    {
        $qb = $this->getActiveQuery();
        $qb
            ->andWhere('n.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param array<int> $category
     * @return News[]
     */
    public function findByTheater(int $theaterId, array $category = [], ?int $limit = null): array
    {
        $qb = $this->getActiveQuery();
        $qb
            ->join('n.theaters', 'pt')
            ->andWhere('pt.theater = :theater_id')
            ->setParameter('theater_id', $theaterId)
            ->orderBy('pt.displayOrder', 'ASC');

        if ($category) {
            $qb
                ->andWhere('n.category IN (:category)')
                ->setParameter('category', $category);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
