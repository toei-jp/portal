<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Title entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="title", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class Title extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    public const RATING_G    = 1;
    public const RATING_PG12 = 2;
    public const RATING_R15  = 3;
    public const RATING_R18  = 4;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     */
    protected ?File $image = null;

    /** @ORM\Column(name="chever_code", type="string", length=100, unique=true, nullable=true) */
    protected ?string $cheverCode = null;

    /** @ORM\Column(type="string") */
    protected string $name;

    /** @ORM\Column(type="string", name="name_kana", nullable=true) */
    protected ?string $nameKana = null;

    /** @ORM\Column(type="string", name="sub_title", nullable=true) */
    protected ?string $subTitle = null;

    /** @ORM\Column(type="string", nullable=true) */
    protected ?string $credit = null;

    /** @ORM\Column(type="text", nullable=true) */
    protected ?string $catchcopy = null;

    /** @ORM\Column(type="text", nullable=true) */
    protected ?string $introduction = null;

    /** @ORM\Column(type="string", nullable=true) */
    protected ?string $director = null;

    /** @ORM\Column(type="string", nullable=true) */
    protected ?string $cast = null;

    /** @ORM\Column(type="date", name="publishing_expected_date", nullable=true) */
    protected ?DateTime $publishingExpectedDate = null;

    /** @ORM\Column(type="string", name="official_site", nullable=true) */
    protected ?string $officialSite = null;

    /** @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true}) */
    protected ?int $rating = null;

    /**
     * @ORM\Column(type="json", nullable=true)
     *
     * @var array<int>|null
     */
    protected ?array $universal = null;

    /**
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="title", indexBy="id")
     *
     * @var Collection<Campaign>
     */
    protected Collection $campaigns;

    /**
     * レイティング区分
     *
     * @var array<int, string>
     */
    protected static array $ratingTypes = [
        '1' => 'G',
        '2' => 'PG12',
        '3' => 'R15+',
        '4' => 'R18+',
    ];

    /**
     * ユニバーサル区分
     *
     * @var array<int, string>
     */
    protected static array $universalTypes = [
        '1' => '音声上映',
        '2' => '字幕上映',
    ];

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

    public function getImage(): ?File
    {
        return $this->image;
    }

    /**
     * @throws LogicException
     */
    public function setImage(?File $image): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getCheverCode(): ?string
    {
        return $this->cheverCode;
    }

    /**
     * @throws LogicException
     */
    public function setCheverCode(?string $cheverCode): void
    {
        throw new LogicException('Not allowed.');
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

    public function getNameKana(): ?string
    {
        return $this->nameKana;
    }

    /**
     * @throws LogicException
     */
    public function setNameKana(?string $nameKana): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    /**
     * @throws LogicException
     */
    public function setSubTitle(?string $subTitle): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    /**
     * @throws LogicException
     */
    public function setCredit(?string $credit): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getCatchcopy(): ?string
    {
        return $this->catchcopy;
    }

    /**
     * @throws LogicException
     */
    public function setCatchcopy(?string $catchcopy): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @throws LogicException
     */
    public function setIntroduction(?string $introduction): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    /**
     * @throws LogicException
     */
    public function setDirector(?string $director): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getCast(): ?string
    {
        return $this->cast;
    }

    /**
     * @throws LogicException
     */
    public function setCast(?string $cast): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPublishingExpectedDate(): ?DateTime
    {
        return $this->publishingExpectedDate;
    }

    /**
     * @param DateTime|string|null $publishingExpectedDate
     *
     * @throws LogicException
     */
    public function setPublishingExpectedDate($publishingExpectedDate): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getOfficialSite(): ?string
    {
        return $this->officialSite;
    }

    /**
     * @throws LogicException
     */
    public function setOfficialSite(?string $officialSite): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @throws LogicException
     */
    public function setRating(?int $rating): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return array<int>|null
     */
    public function getUniversal(): ?array
    {
        return $this->universal;
    }

    /**
     * @return string[]
     */
    public function getUniversalLabel(): array
    {
        $univarsal = $this->getUniversal();
        $types     = self::getUniversalTypes();
        $labels    = [];

        foreach ($univarsal as $value) {
            if (isset($types[$value])) {
                $labels[] = $types[$value];
            }
        }

        return $labels;
    }

    /**
     * @param array<int>|null $universal
     *
     * @throws LogicException
     */
    public function setUniversal(?array $universal): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get campaigns
     *
     * 表示順管理は想定していない。
     * 作品に紐付けられたものを登録された順でよいとのこと。
     *
     * @return Collection<Campaign>
     */
    public function getCampaigns(): Collection
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('isDeleted', false))
            ->andWhere(Criteria::expr()->lte('startDt', new DateTime('now')))
            ->andWhere(Criteria::expr()->gt('endDt', new DateTime('now')))
            ->orderBy(['createdAt' => Criteria::ASC]);

        return $this->campaigns->matching($criteria);
    }

    /**
     * @return array<int, string>
     */
    public static function getRatingTypes(): array
    {
        return self::$ratingTypes;
    }

    /**
     * @return array<int, string>
     */
    public static function getUniversalTypes(): array
    {
        return self::$universalTypes;
    }
}
