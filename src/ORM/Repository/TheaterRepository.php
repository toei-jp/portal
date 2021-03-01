<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\Theater;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TheaterRepository extends EntityRepository
{
    protected function getActiveQuery(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.isDeleted = false');

        return $qb;
    }

    /**
     * @return Theater[]
     */
    public function findByActive(): array
    {
        $qb = $this->getActiveQuery();
        $qb
            ->orderBy('t.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findOneByName(string $name): ?Theater
    {
        $qb = $this->getActiveQuery();
        $qb
            ->andWhere('t.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
