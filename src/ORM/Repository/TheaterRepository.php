<?php

declare(strict_types=1);

namespace App\ORM\Repository;

use App\ORM\Entity\Theater;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TheaterRepository extends EntityRepository
{
    private function addActiveQuery(QueryBuilder $qb, string $alias): void
    {
        $qb->where($alias . '.isDeleted = false');
    }

    /**
     * theaterとtheate_metaのN+1問題を解決するためのクエリを追加
     *
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/faq.html#why-is-an-extra-sql-query-executed-every-time-i-fetch-an-entity-with-a-one-to-one-relation
     */
    private function addFixTheaterMetaNPlasOneQuery(QueryBuilder $qb, string $alias, string $metaAlias): void
    {
        $qb
            ->select(sprintf('%s, %s', $alias, $metaAlias))
            ->innerJoin($alias . '.meta', $metaAlias);
    }

    /**
     * @return Theater[]
     */
    public function findByActive(): array
    {
        $alias = 't';
        $qb    = $this->createQueryBuilder($alias);

        $this->addFixTheaterMetaNPlasOneQuery($qb, $alias, 'tm');
        $this->addActiveQuery($qb, $alias);

        $qb->orderBy($alias . '.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findOneByName(string $name): ?Theater
    {
        $alias = 't';
        $qb    = $this->createQueryBuilder($alias);

        $this->addFixTheaterMetaNPlasOneQuery($qb, $alias, 'tm');
        $this->addActiveQuery($qb, $alias);

        $qb
            ->andWhere($alias . '.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
