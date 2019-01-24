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
     * find one by id
     *
     * @param int $id
     * @return Theater|null
     */
    public function findOneById(int $id)
    {
        $qb = $this->getActiveQuery();
        $qb
            ->andWhere('t.id = :id')
            ->setParameter('id', $id);
            
        return $qb->getQuery()->getOneOrNullResult();
    }
}
