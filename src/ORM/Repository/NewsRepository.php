<?php
/**
 * NewsRepository.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Toei\Portal\ORM\Entity\News;

/**
 * News repository class
 */
class NewsRepository extends EntityRepository
{
    /**
     * return active query
     *
     * @return QueryBuilder
     */
    protected function getActiveQuery()
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
    
    /**
     * find one by id
     *
     * @param int $id
     * @return News|null
     */
    public function findOneById(int $id)
    {
        $qb = $this->getActiveQuery();
        $qb
            ->andWhere('n.id = :id')
            ->setParameter('id', $id);
            
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    /**
     * find by theater
     *
     * @param int      $theaterId
     * @param array    $category
     * @param int|null $limit
     * @return News[]
     */
    public function findByTheater(int $theaterId, array $category = [], ?int $limit = null)
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