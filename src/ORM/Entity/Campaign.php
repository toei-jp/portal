<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Campaign entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\CampaignRepository")
 * @ORM\Table(name="campaign", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class Campaign extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Title")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var Title|null
     */
    protected $title;

    /**
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     *
     * @var File
     */
    protected $image;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime", name="start_dt")
     *
     * @var DateTime
     */
    protected $startDt;

    /**
     * @ORM\Column(type="datetime", name="end_dt")
     *
     * @var DateTime
     */
    protected $endDt;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $url;

    /**
     * @ORM\OneToMany(targetEntity="PageCampaign", mappedBy="campaign")
     *
     * @var Collection<PageCampaign>
     */
    protected $pages;

    /**
     * @ORM\OneToMany(targetEntity="TheaterCampaign", mappedBy="campaign")
     *
     * @var Collection<TheaterCampaign>
     */
    protected $theaters;

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

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    /**
     * @throws LogicException
     */
    public function setTitle(?Title $title): void
    {
        throw new LogicException('Not allowed.');
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

    public function getStartDt(): DateTime
    {
        return $this->startDt;
    }

    /**
     * @param DateTime|string $startDt
     *
     * @throws LogicException
     */
    public function setStartDt($startDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getEndDt(): DateTime
    {
        return $this->endDt;
    }

    /**
     * @param DateTime|string $endDt
     *
     * @throws LogicException
     */
    public function setEndDt($endDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @throws LogicException
     */
    public function setUrl(string $url): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<int, PageCampaign>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @return Collection<int, TheaterCampaign>
     */
    public function getTheaters(): Collection
    {
        return $this->theaters;
    }
}
