<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * MainBanner entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\MainBannerRepository")
 * @ORM\Table(name="main_banner", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class MainBanner extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    public const LINK_TYPE_NONE = 1;
    public const LINK_TYPE_URL  = 2;

    /** @var array<int, string> */
    protected static array $linkTypes = [
        self::LINK_TYPE_NONE => 'リンクなし',
        self::LINK_TYPE_URL  => 'URL',
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected File $image;

    /** @ORM\Column(type="string") */
    protected string $name;

    /** @ORM\Column(type="smallint", name="link_type", options={"unsigned"=true}) */
    protected int $linkType;

    /** @ORM\Column(type="string", name="link_url", nullable=true) */
    protected ?string $linkUrl = null;

    /**
     * @ORM\OneToMany(targetEntity="PageMainBanner", mappedBy="mainBanner")
     *
     * @var Collection<PageMainBanner>
     */
    protected Collection $pages;

    /**
     * @ORM\OneToMany(targetEntity="TheaterMainBanner", mappedBy="mainBanner")
     *
     * @var Collection<TheaterMainBanner>
     */
    protected Collection $theaters;

    /**
     * @return array<int, string>
     */
    public static function getLinkTypes(): array
    {
        return self::$linkTypes;
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

    public function getImage(): File
    {
        return $this->image;
    }

    /**
     * @throws LogicException
     */
    public function setImage(File $image): void
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

    public function getLinkType(): int
    {
        return $this->linkType;
    }

    /**
     * @throws LogicException
     */
    public function setLinkType(int $linkType): void
    {
        throw new LogicException('Not allowed.');
    }

    public function isLinkTypeNone(): bool
    {
        return $this->getLinkType() === self::LINK_TYPE_NONE;
    }

    public function isLinkTypeUrl(): bool
    {
        return $this->getLinkType() === self::LINK_TYPE_URL;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    /**
     * @throws LogicException
     */
    public function setLinkUrl(?string $linkUrl): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<PageMainBanner>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @return Collection<TheaterMainBanner>
     */
    public function getTheaters(): Collection
    {
        return $this->theaters;
    }
}
