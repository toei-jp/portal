<?php
/**
 * MainBannerRepository.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Toei\Portal\ORM\Entity\MainBanner;

/**
 * MainBanner repository class
 */
class MainBannerRepository extends EntityRepository
{
    /**
     * return active query
     *
     * @return QueryBuilder
     */
    protected function getActiveQuery()
    {
        $qb = $this->createQueryBuilder('mb');
        $qb
            ->where('mb.isDeleted = false');
        
        return $qb;
    }
    
    /**
     * find by page_id
     *
     * @param int $pageId
     * @return MainBanner[]
     */
    public function findByPageId(int $pageId)
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
     * find by theater_id
     *
     * @param int $theaterId
     * @return MainBanner[]
     */
    public function findByTheaterId(int $theaterId)
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
