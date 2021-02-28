<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Theater entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\TheaterRepository")
 * @ORM\Table(name="theater", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class Theater extends AbstractEntity
{
    use SoftDeleteTrait;
    use TimestampableTrait;

    /** @var array<int, string> */
    protected static $areas = [];

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="name_ja")
     *
     * @var string
     */
    protected $nameJa;

    /**
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $area;

    /**
     * @ORM\Column(type="string", name="master_code", length=3, options={"fixed":true})
     *
     * @var string
     */
    protected $masterCode;

    /**
     * @ORM\Column(type="smallint", name="display_order", options={"unsigned"=true})
     *
     * @var int
     */
    protected $displayOrder;

    /**
     * 設計の問題でnullを許容する形になってしまったが、nullにならないようデータで調整する。
     *
     * @ORM\OneToOne(targetEntity="TheaterMeta", mappedBy="theater")
     *
     * @var TheaterMeta|null
     */
    protected $meta;

    /**
     * @ORM\OneToMany(targetEntity="AdminUser", mappedBy="theater")
     *
     * @var Collection<AdminUser>
     */
    protected $adminUsers;

    /**
     * @ORM\OneToMany(targetEntity="TheaterCampaign", mappedBy="theater", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<TheaterCampaign>
     */
    protected $campaigns;

    /**
     * @ORM\OneToMany(targetEntity="TheaterNews", mappedBy="theater", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<TheaterNews>
     */
    protected $newsList;

    /**
     * @ORM\OneToMany(targetEntity="TheaterMainBanner", mappedBy="theater", orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     *
     * @var Collection<TheaterMainBanner>
     */
    protected $mainBanners;

    /**
     * @return array<int, string>
     */
    public static function getAreas(): array
    {
        return self::$areas;
    }

    /**
     * @throws LogicException
     */
    public function __construct()
    {
        throw new LogicException('Not allowed.');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws LogicException
     */
    public function setName(string $name): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getNameJa(): string
    {
        return $this->nameJa;
    }

    /**
     * @throws LogicException
     */
    public function setNameJa(string $nameJa): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getArea(): int
    {
        return $this->area;
    }

    /**
     * @throws LogicException
     */
    public function setArea(int $area): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getMasterCode(): string
    {
        return $this->masterCode;
    }

    /**
     * @throws LogicException
     */
    public function setMasterCode(string $masterCode): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    /**
     * @throws LogicException
     */
    public function setDisplayOrder(int $displayOrder): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getMeta(): TheaterMeta
    {
        return $this->meta;
    }

    /**
     * @return Collection<AdminUser>
     */
    public function getAdminUsers(): Collection
    {
        return $this->adminUsers;
    }

    /**
     * @return Collection<TheaterCampaign>
     */
    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }

    /**
     * @return Collection<TheaterNews>
     */
    public function getNewsList(): Collection
    {
        return $this->newsList;
    }

    /**
     * @return Collection<TheaterMainBanner>
     */
    public function getMainBanners(): Collection
    {
        return $this->mainBanners;
    }
}
