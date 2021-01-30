<?php

namespace App\ORM\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Page entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="page", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class Page extends AbstractEntity
{
    use SoftDeleteTrait;
    use TimestampableTrait;

    /**
     * id
     *
     * @ORM\Id
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @var int
     */
    protected $id;

    /**
     * name
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * name_ja
     *
     * @ORM\Column(type="string", name="name_ja")
     *
     * @var string
     */
    protected $nameJa;

    /**
     * campaigns
     *
     * @ORM\OneToMany(targetEntity="PageCampaign", mappedBy="page", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<PageCampaign>
     */
    protected $campaigns;

    /**
     * news_list
     *
     * @ORM\OneToMany(targetEntity="PageNews", mappedBy="page", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<PageNews>
     */
    protected $newsList;

    /**
     * main_banners
     *
     * @ORM\OneToMany(targetEntity="PageMainBanner", mappedBy="page", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<PageMainBanner>
     */
    protected $mainBanners;

    /**
     * construct
     *
     * @throws LogicException
     */
    public function __construct()
    {
        throw new LogicException('Not allowed.');
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
     * get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     *
     * @param string $name
     * @return void
     *
     * @throws LogicException
     */
    public function setName(string $name)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get name_ja
     *
     * @return string
     */
    public function getNameJa()
    {
        return $this->nameJa;
    }

    /**
     * set name_ja
     *
     * @param string $nameJa
     * @return void
     *
     * @throws LogicException
     */
    public function setNameJa(string $nameJa)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get campaigns
     *
     * @return Collection
     */
    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }

    /**
     * get news_list
     *
     * @return Collection
     */
    public function getNewsList(): Collection
    {
        return $this->newsList;
    }

    /**
     * get main_banners
     *
     * @return Collection
     */
    public function getMainBanners(): Collection
    {
        return $this->mainBanners;
    }
}
