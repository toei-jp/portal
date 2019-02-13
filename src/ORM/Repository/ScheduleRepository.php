<?php
/**
 * ScheduleRepository.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Toei\Portal\ORM\Entity\Schedule;

/**
 * Schedule repository class
 */
class ScheduleRepository extends EntityRepository
{
    /**
     * return active query
     *
     * @return QueryBuilder
     */
    protected function getActiveQuery()
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->where('s.isDeleted = false')
            ->andWhere('s.publicStartDt <= CURRENT_TIMESTAMP()')
            ->andWhere('s.publicEndDt > CURRENT_TIMESTAMP()');
        
        return $qb;
    }
    
    /**
     * return showing query
     *
     * @return QueryBuilder
     */
    protected function getShowingQuery()
    {
        $qb = $this->getActiveQuery();
        
        $qb
            ->andWhere('s.startDate <= CURRENT_DATE()')
            ->orderBy('s.startDate', 'DESC');
        
        return $qb;
    }
    
    /**
     * find showing
     *
     * @return Schedule[]
     */
    public function findShowing()
    {
        $qb = $this->getShowingQuery();
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * return soon query
     *
     * @return QueryBuilder
     */
    protected function getSoonQuery()
    {
        $qb = $this->getActiveQuery();
        
        $qb
            ->andWhere('s.startDate > CURRENT_DATE()')
            ->orderBy('s.startDate', 'ASC');
        
        return $qb;
    }
    
    /**
     * find soon
     *
     * @return Schedule[]
     */
    public function findSoon()
    {
        $qb = $this->getSoonQuery();
        
        return $qb->getQuery()->getResult();
    }
}
