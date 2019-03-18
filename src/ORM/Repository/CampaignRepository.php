<?php
/**
 * CampaignRepository.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Toei\Portal\ORM\Entity\Campaign;

/**
 * Campaign repository class
 */
class CampaignRepository extends EntityRepository
{
    /**
     * return active query
     *
     * @return QueryBuilder
     */
    protected function getActiveQuery()
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
     * find by page
     *
     * @param int $pageId
     * @return Campaign[]
     */
    public function findByPage(int $pageId)
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
