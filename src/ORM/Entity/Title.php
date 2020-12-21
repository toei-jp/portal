<?php

namespace Toei\Portal\ORM\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

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
     * image
     *
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var File|null
     */
    protected $image;

    /**
     * chever_code
     *
     * @ORM\Column(name="chever_code", type="string", length=100, unique=true, nullable=true)
     *
     * @var string|null
     */
    protected $cheverCode;

    /**
     * name
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * name_kana
     *
     * @ORM\Column(type="string", name="name_kana", nullable=true)
     *
     * @var string|null
     */
    protected $nameKana;

    /**
     * sub_title
     *
     * @ORM\Column(type="string", name="sub_title", nullable=true)
     *
     * @var string|null
     */
    protected $subTitle;

    /**
     * credit
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    protected $credit;

    /**
     * catchcopy
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $catchcopy;

    /**
     * introduction
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $introduction;

    /**
     * director
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    protected $director;

    /**
     * cast
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    protected $cast;

    /**
     * publishing_expected_date
     *
     * @ORM\Column(type="date", name="publishing_expected_date", nullable=true)
     *
     * @var \DateTime|null
     */
    protected $publishingExpectedDate;

    /**
     * official_site
     *
     * @ORM\Column(type="string", name="official_site", nullable=true)
     *
     * @var string|null
     */
    protected $officialSite;

    /**
     * rating
     *
     * @ORM\Column(type="smallint", nullable=true, options={"unsigned"=true})
     *
     * @var int|null
     */
    protected $rating;

    /**
     * universal
     *
     * @ORM\Column(type="json", nullable=true)
     *
     * @var array|null
     */
    protected $universal;

    /**
     * campaigns
     *
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="title", indexBy="id")
     *
     * @var Collection<Campaign>
     */
    protected $campaigns;

    /**
     * レイティング区分
     *
     * @var array
     */
    protected static $ratingTypes = [
        '1' => 'G',
        '2' => 'PG12',
        '3' => 'R15+',
        '4' => 'R18+',
    ];

    /**
     * ユニバーサル区分
     *
     * @var array
     */
    protected static $universalTypes = [
        '1' => '音声上映',
        '2' => '字幕上映',
    ];

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
     * get image
     *
     * @return File|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * set image
     *
     * @param File|null $image
     * @return void
     *
     * @throws \LogicException
     */
    public function setImage($image)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get chever_code
     *
     * @return string|null
     */
    public function getCheverCode()
    {
        return $this->cheverCode;
    }

    /**
     * set chever_code
     *
     * @param string|null $cheverCode
     * @return void
     *
     * @throws \LogicException
     */
    public function setCheverCode(?string $cheverCode)
    {
        throw new \LogicException('Not allowed.');
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
     * @throws \LogicException
     */
    public function setName(string $name)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get name_kana
     *
     * @return string|null
     */
    public function getNameKana()
    {
        return $this->nameKana;
    }

    /**
     * set name_kana
     *
     * @param string|null $nameKana
     * @return void
     *
     * @throws \LogicException
     */
    public function setNameKana(?string $nameKana)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get sub_title
     *
     * @return string|null
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * set sub_title
     *
     * @param string|null $subTitle
     * @return void
     *
     * @throws \LogicException
     */
    public function setSubTitle(?string $subTitle)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * credit
     *
     * @return string|null
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * set credit
     *
     * @param string|null $credit
     * @return void
     *
     * @throws \LogicException
     */
    public function setCredit(?string $credit)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get catchcopy
     *
     * @return string|null
     */
    public function getCatchcopy()
    {
        return $this->catchcopy;
    }

    /**
     * set catchcopy
     *
     * @param string|null $catchcopy
     * @return void
     *
     * @throws \LogicException
     */
    public function setCatchcopy(?string $catchcopy)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get introduction
     *
     * @return string|null
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * set introduction
     *
     * @param string|null $introduction
     * @return void
     *
     * @throws \LogicException
     */
    public function setIntroduction(?string $introduction)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get director
     *
     * @return string|null
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * set director
     *
     * @param string|null $director
     * @return void
     *
     * @throws \LogicException
     */
    public function setDirector(?string $director)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get cast
     *
     * @return string|null
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * set cast
     *
     * @param string|null $cast
     * @return void
     *
     * @throws \LogicException
     */
    public function setCast(?string $cast)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get publishing_expected_date
     *
     * @return \DateTime|null
     */
    public function getPublishingExpectedDate()
    {
        return $this->publishingExpectedDate;
    }

    /**
     * set publishing_dxpected_date
     *
     * @param \DateTime|string|null $publishingExpectedDate
     * @return void
     *
     * @throws \LogicException
     */
    public function setPublishingExpectedDate($publishingExpectedDate)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get official_site
     *
     * @return string|null
     */
    public function getOfficialSite()
    {
        return $this->officialSite;
    }

    /**
     * set official_site
     *
     * @param string|null $officialSite
     * @return void
     *
     * @throws \LogicException
     */
    public function setOfficialSite(?string $officialSite)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get rating
     *
     * @return int|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * set rating
     *
     * @param int|null $rating
     * @return void
     *
     * @throws \LogicException
     */
    public function setRating(?int $rating)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get universal
     *
     * @return array|null
     */
    public function getUniversal()
    {
        return $this->universal;
    }

    /**
     * get univarsal label
     *
     * @return array
     */
    public function getUniversalLabel()
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
     * set universal
     *
     * @param array|null $universal
     * @return void
     *
     * @throws \LogicException
     */
    public function setUniversal(?array $universal)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get campaigns
     *
     * 表示順管理は想定していない。
     * 作品に紐付けられたものを登録された順でよいとのこと。
     *
     * @return Collection
     */
    public function getCampaigns()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('isDeleted', false))
            ->andWhere(Criteria::expr()->lte('startDt', new \DateTime('now')))
            ->andWhere(Criteria::expr()->gt('endDt', new \DateTime('now')))
            ->orderBy(['createdAt' => Criteria::ASC]);

        return $this->campaigns->matching($criteria);
    }

    /**
     * get レイティング区分
     *
     * @return array
     */
    public static function getRatingTypes()
    {
        return self::$ratingTypes;
    }

    /**
     * get ユニバーサル区分
     *
     * @return array
     */
    public static function getUniversalTypes()
    {
        return self::$universalTypes;
    }
}
