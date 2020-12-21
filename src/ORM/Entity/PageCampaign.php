<?php

/**
 * PageCampaign.php
 */

namespace Toei\Portal\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageCampaign entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="page_campaign", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class PageCampaign extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * id
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * campaign
     *
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="pages")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Campaign
     */
    protected $campaign;

    /**
     * page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="campaigns")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Page
     */
    protected $page;

    /**
     * display_order
     *
     * @ORM\Column(type="smallint", name="display_order", options={"unsigned"=true})
     *
     * @var int
     */
    protected $displayOrder;

    /**
     * construct
     *
     * @throws \LogicException
     */
    public function __construct()
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get campaign
     *
     * @return Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * set campaign
     *
     * @param Campaign $campaign
     * @return void
     *
     * @throws \LogicException
     */
    public function setCampaign(Campaign $campaign)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * set page
     *
     * @param Page $page
     * @return void
     *
     * @throws \LogicException
     */
    public function setPage(Page $page)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get display_order
     *
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * set display_order
     *
     * @param int $displayOrder
     * @return void
     *
     * @throws \LogicException
     */
    public function setDisplayOrder(int $displayOrder)
    {
        throw new \LogicException('Not allowed.');
    }
}
