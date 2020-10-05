<?php

/**
 * TheaterRepository.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Toei\Portal\ORM\Entity\Theater;

/**
 * Theater repository class
 */
class TheaterRepository extends EntityRepository
{
    /**
     * return active query
     *
     * @return QueryBuilder
     */
    protected function getActiveQuery()
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.isDeleted = false');

        return $qb;
    }

    /**
     * find by active
     *
     * @return Theater[]
     */
    public function findByActive()
    {
        $qb = $this->getActiveQuery();
        $qb
            ->orderBy('t.displayOrder', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * find one by name
     *
     * @param string $name
     * @return Theater|null
     */
    public function findOneByName(string $name)
    {
        $qb = $this->getActiveQuery();
        $qb
            ->andWhere('t.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
